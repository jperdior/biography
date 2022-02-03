<?php

namespace App\Controller\Rest;

use App\Entity\Person;
use App\Entity\Note;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

class NoteController extends AbstractFOSRestController{


    /**
     * @Rest\Get("/notes/{personId}")
     */
    public function getNotesAction(string $personId,Request $request, SerializerInterface $serializer, ManagerRegistry $registry){
        /**
         * @var Person $person
         */
        $person = $registry->getRepository(Person::class)->find($personId);
        if(!$person){
            return new JsonResponse(['message'=>'Person not found'],Response::HTTP_NOT_FOUND);
        }
        $notes = $registry->getRepository(Note::class)->findBy(['person'=>$person,'approved'=>true]);
        $data = $serializer->serialize($notes,'json',['groups'=>['note:read']]);
        return new JsonResponse($data,Response::HTTP_OK,[],true);
    }

    /**
     * @Rest\Get("/admin_notes")
     */
    public function getAdminNotesAction(Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry){
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $person =  $managerRegistry->getRepository('App:Person')->findOneBy(['user' => $user->getId(), 'mainPerson' => true]);
        $notes = $managerRegistry->getRepository(Note::class)->findBy(['person'=>$person,'verified'=>true]);
        $data = $serializer->serialize($notes,'json',['groups'=>['note:read']]);
        return new JsonResponse($data,Response::HTTP_OK,[],true);
    }

    /**
     * @Rest\Get("/notes/{token}/{noteId}/verify")
     */
    public function verifyNoteAction(string $token,string $noteId,Request $request, SerializerInterface $serializer, ManagerRegistry $registry){
        /**
         * @var Note $note
         */
        $note = $registry->getRepository(Note::class)->find($noteId);
        if(!$note){
            return new JsonResponse(['message'=>'Note not found'],Response::HTTP_NOT_FOUND);
        }
        if($note->getVerificationToken() !== $token){
            return new JsonResponse(['message'=>'Invalid token'],Response::HTTP_NOT_FOUND);
        }
        $note->setVerified(true);
        $registry->getManager()->flush();
        $data = $serializer->serialize($note,'json',['groups'=>['note:read']]);
        return new JsonResponse($data,Response::HTTP_OK,[],true);
    }

    /**
     * @Rest\Post("/notes/{personId}")
     */
    public function postNoteAction(string $personId,Request $request, ManagerRegistry $managerRegistry, SerializerInterface $serializer){
        /**
         * @var Person $person
         */
        $person = $managerRegistry->getRepository(Person::class)->find($personId);
        if(!$person){
            return new JsonResponse(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }
        if($person->getNeedsLogin() || !$person->getAllowNotesOrGalleries()){
            return new JsonResponse(['message' => 'You are not allowed to add notes to this person'], Response::HTTP_FORBIDDEN);
        }
        /**
         * @var Note $note
         */
        $note = $serializer->deserialize($request->getContent(), Note::class, 'json',['groups'=>'note:write']);
        $note->setPerson($person);
        $note->setVerified(true);
        $note->setVerificationToken(Uuid::v4());
        $managerRegistry->getManager()->persist($note);
        $managerRegistry->getManager()->flush();
        return new JsonResponse(['message' => 'Note added'], Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/notes/{noteId}/approve")
     */
    public function approveNoteAction(string $noteId,Request $request, ManagerRegistry $managerRegistry){
        /**
         * @var Note $note
         */
        $note = $managerRegistry->getRepository(Note::class)->find($noteId);
        if(!$note){
            return new JsonResponse(['message' => 'Note not found'], Response::HTTP_NOT_FOUND);
        }
        if(!$note->isOwner($this->getUser())){
            return new JsonResponse(['message' => 'You are not allowed to approve this note'], Response::HTTP_FORBIDDEN);
        }

        $note->setApproved(true);
        $managerRegistry->getManager()->flush();
        return new JsonResponse(['message' => 'Note approved'], Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/notes/{noteId}/disapprove")
     */
    public function disapproveNoteAction(string $noteId,Request $request, ManagerRegistry $managerRegistry){
        /**
         * @var Note $note
         */
        $note = $managerRegistry->getRepository(Note::class)->find($noteId);
        if (!$note) {
            return new JsonResponse(['message' => 'Note not found'], Response::HTTP_NOT_FOUND);
        }
        if (!$note->isOwner($this->getUser())) {
            return new JsonResponse(['message' => 'You are not allowed to disapprove this note'], Response::HTTP_FORBIDDEN);
        }

        $note->setApproved(false);
        $managerRegistry->getManager()->flush();
        return new JsonResponse(['message' => 'Note disapproved'], Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/notes/{noteId}")
     */
    public function deleteNoteAction(string $noteId, ManagerRegistry $managerRegistry){
        /**
         * @var Note $note
         */
        $note = $managerRegistry->getRepository(Note::class)->find($noteId);
        if (!$note) {
            return new JsonResponse(['message' => 'Note not found'], Response::HTTP_NOT_FOUND);
        }
        $managerRegistry->getManager()->remove($note);
        $managerRegistry->getManager()->flush();
        return new JsonResponse(['message' => 'Note deleted'], Response::HTTP_OK);
    }


}