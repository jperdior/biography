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




        $em->persist($gallery);
        $em->flush();

        return $data;
    }
}
