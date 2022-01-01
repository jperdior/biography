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

class PersonController extends AbstractFOSRestController{


    /**
     * @Rest\Get("/people", name="getPersons")
     */
    public function getPersonsAction(ManagerRegistry $doctrine, SerializerInterface $serializer){

        /**
         * @var User $user
         */
        $user = $this->getUser();
        $persons =  $doctrine->getRepository('App:Person')->findBy(['user' => $user->getId()]);
        $data = $serializer->serialize($persons, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
        return $object->getId();
    }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Get("/people/main", name="getMainPerson")
     */
    public function getMainPersonAction(ManagerRegistry $doctrine, SerializerInterface $serializer){

            /**
            * @var User $user
            */
            $user = $this->getUser();
            $person =  $doctrine->getRepository('App:Person')->findOneBy(['user' => $user->getId(), 'mainPerson' => true]);
            $data = $serializer->serialize($person, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
            return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    /**
     * @Rest\Get("/people/{id}", name="getPerson")
     */
    public function getPersonAction(string $id, ManagerRegistry $doctrine, SerializerInterface $serializer, ExtraInfoService $extraInfoService){

        /**
         * @var Person $person
         */
        $person = $doctrine->getRepository('App:Person')->findOneBy(['id' => $id]);
        if(!$person){
            return $this->json(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }
        if($person->getNeedsLogin()){
            if($person->getUser()->getId() !== $this->getUser()->getId()){
                return $this->json(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
            }
        }
        $extraInfoService->calculatePersonExtraInfo($person, $this->getParameter('private_galleries_directory'));
        $data = $serializer->serialize($person, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);

    }

    // /**
    //  * @Rest\Post("/people", name="postPerson")
    //  */
    // public function postPersonAction(ManagerRegistry $doctrine, SerializerInterface $serializer){

    //     $person = new Person();
    //     $person->setUser($this->getUser());
    //     $person->setMainPerson(false);
    //     $person->setNicknames([]);
    //     $person->setLastnames('');
    //     $person->setName('');
    //     $person->setTreatment(Person::NEUTRAL_TREATMENT);
    //     $person->setMainPicture('');
    //     $doctrine->getManager()->persist($person);
    //     $doctrine->getManager()->flush();
    //     $data = $serializer->serialize($person, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
    //         return $object->getId();
    //     }]);
    //     return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    // }

    /**
     * @Rest\Put("/people/{id}", name="putPerson")
     */
    public function putPersonAction(
        string $id,
        Request $request,
        ManagerRegistry $doctrine,
        SerializerInterface $serializer,
        FamilyService $familyService,
        ExtraInfoService $extraInfoService){

        /**
         * @var User $user
         */
        $user = $this->getUser();
        $person = $doctrine->getRepository('App:Person')->findOneBy(['id' => $id]);
        if(!$person){
            return $this->json(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }
        if($person->getUser()->getId() != $user->getId()){
            return $this->json(['message' => 'You are not allowed to edit this person'], Response::HTTP_FORBIDDEN);
        }

        $data = $serializer->deserialize(
            $request->getContent(),
            Person::class,
            'json',
            ['object_to_populate' => $person,'groups'=>'person:write']
        );
        $deserializedData = json_decode($request->getContent(), true);
        if(isset($deserializedData["parents"])){
            $processParentsResult = $familyService->processParents($person,$deserializedData["parents"], $doctrine, $this->getUser());
            if(!$processParentsResult){
                return $this->json(['message' => 'You are not allowed to edit this parent'], Response::HTTP_FORBIDDEN);
            }
        }
        if (isset($deserializedData["children"])) {
            $processChildrenResult = $familyService->processChildren($person, $deserializedData["children"], $doctrine, $this->getUser());
            if (!$processChildrenResult) {
                return $this->json(['message' => 'You are not allowed to edit this child'], Response::HTTP_FORBIDDEN);
            }
        }
        // dump($deserializedData["favorites"]);die;
        if (isset($deserializedData["favorites"])){
            $processFavoritesResult = $extraInfoService->processFavorites($person, $deserializedData["favorites"], $doctrine, $this->getUser());
            if (!$processFavoritesResult) {
                return $this->json(['message' => 'You are not allowed to edit this favorite'], Response::HTTP_FORBIDDEN);
            }
        }
        $doctrine->getManager()->flush();
        $extraInfoService->calculatePersonExtraInfo($person, $this->getParameter('private_galleries_directory'));
        $data = $serializer->serialize($person, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }


    /**
     * @Rest\Get("/people/{id}/needslogin", name="personNeedsLogin")
     */
    public function personNeedsLoginAction(string $id, ManagerRegistry $doctrine){

        /**
         * @var Person $person
         */
        $person = $doctrine->getRepository('App:Person')->findOneBy(['id' => $id]);
        if (!$person) {
            return $this->json(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }
        if ($person->getNeedsLogin()) {
            return new JsonResponse(['needsLogin' => true], Response::HTTP_OK, [], true);
        }
        return new JsonResponse(['needsLogin' => false], Response::HTTP_OK, []);
    }
}