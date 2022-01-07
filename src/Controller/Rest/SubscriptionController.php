<?php

namespace App\Controller\Rest;


use App\Entity\Familiar;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Person;
use App\Entity\User;
use App\Service\StripeService;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class SubscriptionController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("/subscription", name="getSubscription")
     */
    public function getSubscriptionAction(){
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if(!$user->getSubscription()){
            return new JsonResponse(['subscription'=>false], Response::HTTP_OK);
        }
        $stripeService = new StripeService($this->getParameter('stripe_secret_key'));
        $subscription = $stripeService->getSubscription($user->getSubscription());
        return new JsonResponse(['subscription'=>$subscription]);

    }
}