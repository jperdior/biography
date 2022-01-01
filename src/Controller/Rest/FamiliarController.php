<?php

namespace App\Controller\Rest;

use App\Entity\Familiar;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Person;
use App\Entity\User;
use App\Service\ExtraInfoService;
use App\Service\FamilyService;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class FamiliarController extends AbstractFOSRestController
{


    /**
     * @Rest\Post("/children/{idPerson}", name="postChildren")
     */
    public function postChildrenAction(string $idPerson, ManagerRegistry $doctrine, SerializerInterface $serializer, Request $request, FamilyService $familyService){

        /**
         * @var User $user
         */
        $user = $this->getUser();
        $person = $doctrine->getRepository('App:Person')->findOneBy(['id' => $idPerson, 'user' => $user->getId()]);
        if(!$person){
            return new JsonResponse(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }
        $familiar = new Familiar();
        $familiar->setParent($person);
        $person->addChild($familiar);
        $doctrine->getManager()->persist($person);
        $doctrine->getManager()->persist($familiar);
        $doctrine->getManager()->flush();
        $data = $serializer->serialize($person, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Delete("/child/{id}", name="deleteChild")
     */
    public function deleteChildAction(int $id, ManagerRegistry $doctrine){
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $familiar = $doctrine->getRepository('App:Familiar')->findOneBy(['id' => $id, 'user' => $user->getId()]);
        if(!$familiar){
            return new JsonResponse(['message' => 'Familiar not found'], Response::HTTP_NOT_FOUND);
        }
        if(!$familiar->getParent()){
            return new JsonResponse(['message' => 'Familiar not found'], Response::HTTP_NOT_FOUND);
        }
        $parent = $familiar->getParent();
        $parent->removeChild($familiar);
        $doctrine->getManager()->persist($parent);
        $doctrine->getManager()->remove($familiar);
        $doctrine->getManager()->flush();
        return new JsonResponse(['message' => 'Familiar deleted'], Response::HTTP_OK);
    }

}