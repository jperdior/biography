<?php

namespace App\Controller\Gallery;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[AsController]
class CreateGallery extends AbstractController
{

    public function __invoke(Gallery $data, Request $request, SluggerInterface $slugger , ManagerRegistry $doctrine): Gallery
    {
        $em = $doctrine->getManager();
        /**
         * @var Person $person
         */
        if($request->get('person_id')){
            $person = $em->getRepository(Person::class)->find($request->get('person_id'));
            $gallery = new Gallery();
            $gallery->setPerson($person);
        }
        else{
            $gallery = $em->getRepository(Gallery::class)->find($request->get('gallery_id'));
        }
        $uploadPath = $this->getParameter('private_galleries_directory');
        $images = $request->files->get('images');
        $gallery->setTitle($request->get('title'));

        foreach($images as $image){
            $imageEntity = new Image();
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();


            try {
                $image->move(
                    $uploadPath,
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $imageEntity->setFilePath($newFilename);
            $imageEntity->setGallery($gallery);
            $em->persist($imageEntity);

        }

        $em->persist($gallery);
        $em->flush();

        return $data;
    }
}
