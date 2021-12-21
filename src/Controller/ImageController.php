<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
}