<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;
use App\Model\Product;
use App\Entity\User;
use App\Entity\Purchase;
use Doctrine\Persistence\ManagerRegistry;

class StripeService{

    const DOMAIN = 'http://memorate.local';
    const MAINTENANCE_PRODUCT = 'prod_KtNLv9HqG7hTgM';
    const MAINTENANCE_PRICE = 'price_1KDaaWEqwNCenL8ZoLzf2Lxa';

    private $secretKey;

    private $client;

    public function __construct(string $secretKey){
        $this->secretKey = $secretKey;
        $this->client = new StripeClient($this->secretKey);
    }

    public function getOneTimeProducts(){
        $products = [];
        $prices = $this->client->prices->all(['type'=>'one_time']);
        foreach($prices->data as $price){
            $stripeProduct = $this->getProduct($price->product);
            $product = $this->createProduct($stripeProduct,$price);
            $products[] = $product;
        }
        return $products;
    }

    public function getProduct(string $productId){

        $product = $this->client->products->retrieve($productId);
        return $product;
    }

    public function getSubscription(string $subscriptionId){
        $subscription = $this->client->subscriptions->retrieve($subscriptionId);
        return $subscription;
    }

    public function createProduct(StripeProduct $stripeProduct, StripePrice $stripePrice){
        $product = new Product();
        $product->setId($stripeProduct->id);
        $product->setName($stripeProduct->name);
        $product->setDescription($stripeProduct->description);
        $product->setAmount($stripePrice->unit_amount/100);
        $product->setCurrency($stripePrice->currency);
        $product->setIdPrice($stripePrice->id);
        return $product;
    }

    public function getMaintenanceProduct(){
        $stripePrice = $this->client->prices->retrieve(self::MAINTENANCE_PRICE);
        $stripeProduct = $this->getProduct($stripePrice->product);
        $product = $this->createProduct($stripeProduct,$stripePrice);
        return $product;
    }


    public function getCheckoutUrl(array $lineItems, string $paymentType, User $user){
        Stripe::setApiKey($this->secretKey);
        $checkout_session = Session::create([
            'line_items' => [$lineItems],
            'client_reference_id' => $user->getId(),
            'mode' => $paymentType,
                'success_url' => self::DOMAIN . '/#/dashboard',
                'cancel_url' => self::DOMAIN . '/#/dashboard' ,
            ]);
        return $checkout_session->url;
    }

    public function processEvent($event, ManagerRegistry $managerRegistry){
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->processCheckoutSessionCompleted($event, $managerRegistry);
                break;
            case 'payment_intent.succeeded':
                $this->processPaymentIntentSucceded($event, $managerRegistry);
                break;
        }
    }

    private function processCheckoutSessionCompleted($event, ManagerRegistry $managerRegistry){
        $user = $managerRegistry->getRepository(User::class)->find($event->data->object->client_reference_id);
        $idempotency_key = $event->request->idempotency_key;
        $subscription = $event->data->object->subscription;
        $purchase = new Purchase();
        $purchase->setIdempotencyKey($idempotency_key);
        $purchase->setSubscription($subscription);
        $purchase->setUser($user);
        $managerRegistry->getManager()->persist($purchase);
        $managerRegistry->getManager()->flush();
    }

    private function processPaymentIntentSucceded($event, ManagerRegistry $managerRegistry){
        /**
         * @var Purchase $purchase
         */
        $purchase = $managerRegistry->getRepository(Purchase::class)->findOneBy(['idempotencyKey'=>$event->request->idempotency_key]);
        $purchase->setStatus($event->data->object->status);
        $managerRegistry->getManager()->persist($purchase);
        $managerRegistry->getManager()->flush();
        if ($event->data->object->status === 'succeeded') {
            $purchase->getUser()->setSubscription($purchase->getSubscription());
            $purchase->getUser()->setActiveSubscription(true);
            $managerRegistry->getManager()->persist($purchase->getUser());
            $managerRegistry->getManager()->flush();
        }

    }
}