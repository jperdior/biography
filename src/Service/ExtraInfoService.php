<?php

namespace App\Service;

use App\Entity\Familiar;
use App\Entity\Person;
use App\Entity\User;
use App\Entity\Favorite;
use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\ImageService;
use Symfony\Component\DependencyInjection\Container;

class ExtraInfoService{

    private $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }


    public function processFavorites(Person $person, $favorites,  ManagerRegistry $doctrine, User $user){
        foreach($favorites as $fav){
            if(!isset($fav['id'])){
                $favorite = new Favorite();
                $favorite->setType($fav["type"]);
                $favorite->setFavorites($fav["favorites"]);
                $favorite->setPerson($person);
                $doctrine->getManager()->persist($favorite);
                continue;
            }
            $favorite = $doctrine->getRepository('App:Favorite')->findOneBy(['id' => $fav["id"]]);
            if($favorite->getPerson()->getUser()->getId() != $user->getId()){
                return false;
            }
            $favorite->setType($fav["type"]);
            $favorite->setFavorites($fav["favorites"]);
            $doctrine->getManager()->persist($favorite);
        }
        return true;
    }

    public function calculatePersonExtraInfo(Person $person, string $privateDirectory){
        $person->mainPictureBase64 = $this->getPersonMainImage($person, $privateDirectory);
        foreach($person->getParents() as $parent){
            $parent->mainPictureBase64 = $this->getFamiliarMainImage($parent, $privateDirectory);
        }
        foreach($person->getChildren() as $child){
            $child->mainPictureBase64 = $this->getFamiliarMainImage($child, $privateDirectory);
        }
        foreach($person->getGalleries() as $gallery){
            foreach($gallery->getImages() as $image){
                $image->filePathBase64 = $this->getGalleryImage($image, $privateDirectory);
            }
        }

    }

    private function getPersonMainImage(Person $person, string $privateDirectory, string $format= "thumb"): string{
        if(!$person->getMainPicture()){
            return "";
        }
        $absolutePath = $privateDirectory .$format."/". $person->getMainPicture();
        try{
            $data = file_get_contents($absolutePath);
        }
        catch(\Exception $e){
            $this->imageService->resizeImage($person->getMainPicture(), $privateDirectory);
        }
        $data = file_get_contents($absolutePath);
        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    private function getFamiliarMainImage(
        Familiar $familiar,
         string $privateDirectory,
          string $format = "thumb"): string{
        if(!$familiar->getMainPicture()){
            return "";
        }
        $absolutePath = $privateDirectory .$format."/". $familiar->getMainPicture();
        try{
            $data = file_get_contents($absolutePath);
        }
        catch(\Exception $e){
            $this->imageService->resizeImage($familiar->getMainPicture(), $privateDirectory);
        }
        $data = file_get_contents($absolutePath);
        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    private function getGalleryImage(
        Image $image,
         string $privateDirectory,
          string $format = "thumb"): string{
        $absolutePath = $privateDirectory .$format."/". $image->getFilePath();
        try{
            $data = file_get_contents($absolutePath);
        }
        catch(\Exception $e){
            $this->imageService->resizeImage($image->getFilePath(), $privateDirectory);
        }
        $data = file_get_contents($absolutePath);
        $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

}