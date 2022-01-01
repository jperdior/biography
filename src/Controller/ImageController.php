<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Image;
use App\Entity\Person;
use App\Entity\Familiar;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;

class ImageController extends AbstractController
{

    #[Route('/security/images/{id}', name: 'image_show')]
    public function serveImage(int $id,Request $request, ManagerRegistry $doctrine): Response
    {
        /**
         * @var Image $image
         */
        $image = $doctrine->getRepository(Image::class)->find($id);
        if($image->getGallery()->getPerson()->getNeedsLogin() && !$this->isGranted('ROLE_USER')){
            $array = array('success' => false);
            $response = new Response(json_encode($array), 401);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        $absolutePath = $this->getParameter('private_galleries_directory') . $image->getFilePath();
        $data = file_get_contents($absolutePath);
        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return new Response($base64);
    }

    #[Route('/api/image/{id}/person', name: 'post_image_person')]
    public function uploadPersonMainPicture(
        string $id,Request $request,
         ManagerRegistry $doctrine,
          SluggerInterface $slugger,
          ImageService $imageService): Response
    {
        /**
         * @var Person $person
         */
        $person = $doctrine->getRepository(Person::class)->find($id);

        if($request->getMethod() == "POST"){
            $uploadPath = $this->getParameter('private_galleries_directory');
            $mainPicture = $request->files->get('mainPicture');
            $originalFilename = $mainPicture->getClientOriginalName();
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$mainPicture->guessExtension();
            $mainPicture->move($uploadPath, $newFilename);
            $person->setMainPicture($newFilename);
            $imageService->resizeImage($newFilename, $this->getParameter('private_galleries_directory'));
            $em = $doctrine->getManager();
            $em->persist($person);
            $em->flush();
        }

        $absolutePath = $this->getParameter('private_galleries_directory') ."thumb/". $person->getMainPicture();

        $data = file_get_contents($absolutePath);
        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return new Response($base64);
    }

    #[Route('/api/image/{id}/familiar', name: 'post_image_familiar')]
    public function uploadFamiliarMainPicture(
        int $id,
        Request $request,
         ManagerRegistry $doctrine,
          SluggerInterface $slugger,
          ImageService $imageService): Response
    {
        /**
         * @var Familiar $familiar
         */
        $familiar = $doctrine->getRepository(Familiar::class)->find($id);

        if($request->getMethod() == "POST"){
            $uploadPath = $this->getParameter('private_galleries_directory');
            $mainPicture = $request->files->get('mainPicture');
            $originalFilename = $mainPicture->getClientOriginalName();
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$mainPicture->guessExtension();
            $mainPicture->move($uploadPath, $newFilename);
            $familiar->setMainPicture($newFilename);
            $imageService->resizeImage($newFilename, $this->getParameter('private_galleries_directory'));
            $em = $doctrine->getManager();
            $em->persist($familiar);
            $em->flush();
        }

        $absolutePath = $this->getParameter('private_galleries_directory') . "thumb/". $familiar->getMainPicture();
        $data = file_get_contents($absolutePath);
        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return new Response($base64);
    }
}