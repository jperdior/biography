<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Entity\User;
use App\Service\StripeService;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/products")
     */
    public function getProductsAction(SerializerInterface $serializer)
    {
        $stripeService = new StripeService($this->getParameter('stripe_secret_key'));
        $products = $stripeService->getOneTimeProducts();
        $data = $serializer->serialize($products, 'json');
        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Get("/maintenance-product")
     */
    public function getMaintenanceProduct(SerializerInterface $serializer)
    {
        $stripeService = new StripeService($this->getParameter('stripe_secret_key'));
        $product = $stripeService->getMaintenanceProduct();
        $data = $serializer->serialize($product, 'json');
        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Rest\Get("/success/subscription")
     */
    public function getSuccessSubscription(Request $request, ManagerRegistry $managerRegistry, SerializerInterface $serializer){


        die("Exito en la suscripcion");
    }

   /**
    * @Rest\Post("/stripe/webhook"))
    */
    public function stripeWebhook(Request $request, ManagerRegistry $managerRegistry, SerializerInterface $serializer){
        $endpoint_secret = 'whsec_rJ64PjTbab3uACzq6sYNKWVvPDQs5iAr';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $endpoint_secret
        );
        } catch(\UnexpectedValueException $e) {
        // Invalid payload
        http_response_code(400);
        exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Invalid signature
        http_response_code(400);
        exit();
        }
        $stripeService = new StripeService($this->getParameter('stripe_secret_key'));
        $stripeService->processEvent($event,$managerRegistry);

        die;

    }

    /**
     * @Rest\Post("/ecommerce/checkout")
     */
    public function checkoutAction(Request $request, SerializerInterface $serializer){
        $stripeService = new StripeService($this->getParameter('stripe_secret_key'));
        $productLines = json_decode($request->getContent(), true);
        if(!count($productLines)){
            $productLines = [];
            $maintenanceProduct = $stripeService->getMaintenanceProduct();
            $maintenanceProduct = [
                'price' => $maintenanceProduct->getIdPrice(),
                'quantity' => 1
            ];
            $productLines[] = $maintenanceProduct;
            $paymentType = 'subscription';
        }
        else{
            $paymentType = 'one_time';
        }
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $checkoutUrl = $stripeService->getCheckoutUrl($productLines, $paymentType, $user);
        return new JsonResponse($checkoutUrl, 200, [], true);
    }
}