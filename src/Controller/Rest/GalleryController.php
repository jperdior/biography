<?php

namespace App\Controller\Rest;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Person;
use App\Service\ImageService;
use Doctrine\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class GalleryController extends AbstractFOSRestController
{

    /**
     * @Rest\Post("/gallery/{id}/update")
     */
    public function postGalleryUpdateAction(int $id, Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, SerializerInterface $serializer){
        /**
         * @var Gallery $gallery
         */
        $gallery = $doctrine->getRepository(Gallery::class)->find($id);
        if(!$gallery){
            return new JsonResponse(['message' => 'Gallery not found'], Response::HTTP_NOT_FOUND);
        }
        if($gallery->getPerson()->getUser()->getId() !== $this->getUser()->getId()){
            return new JsonResponse(['message' => 'You are not allowed to edit this gallery'], Response::HTTP_FORBIDDEN);
        }
        $gallery->setTitle($request->get('title'));
        $em = $doctrine->getManager();
        $uploadPath = $this->getParameter('private_galleries_directory');
        $images = $request->files->get('images');

        foreach($images as $image){
            $imageEntity = new Image();
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                $image->move(
                    $uploadPath,
                    $newFilename
                );

            $imageEntity->setFilePath($newFilename);
            $imageEntity->setGallery($gallery);
            $em->persist($imageEntity);
        }
        $uploadPath = $this->getParameter('private_galleries_directory');
        $em->persist($gallery);
        $em->flush();

        $data = $serializer->serialize($gallery->getPerson(), 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);

    }


    /**
     * @Rest\Post("/galleries/{id}", name="postGallery")
     */
    public function postGalleryAction(
        string $id,
        Request $request,
        ManagerRegistry $doctrine,
        SluggerInterface $slugger,
        SerializerInterface $serializer,
        ImageService $imageService
        ){

        $person = $doctrine->getRepository(Person::class)->find($id);
        if(!$person){
            return $this->json(['message' => 'Person not found'], Response::HTTP_NOT_FOUND);
        }

        $em = $doctrine->getManager();
        $uploadPath = $this->getParameter('private_galleries_directory');
        $gallery = new Gallery();
        $gallery->setPerson($person);
        $gallery->setTitle($request->get('title'));

        $images = $request->files->get('images');
        foreach($images as $image){
            $imageEntity = new Image();
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                $image->move(
                    $uploadPath,
                    $newFilename
                );

            $imageEntity->setFilePath($newFilename);
            $imageService->resizeImage($newFilename, $uploadPath);
            $imageEntity->setGallery($gallery);
            $em->persist($imageEntity);
        }
        $em->persist($gallery);
        $em->flush();

        $data = $serializer->serialize($person, 'json',['groups' => 'person:read','circular_reference_handler' => function ($object) {
            return $object->getId();
        }]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

}