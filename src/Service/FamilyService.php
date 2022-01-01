<?php

namespace App\Service;

use App\Entity\Person;
use App\Entity\Familiar;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class FamilyService{

    public function processParents(Person $person, array $parents, ManagerRegistry $doctrine, User $user) : bool{
        foreach($parents as $parent){
            if(!isset($parent['id'])){
                $familiar = new Familiar();
                $familiar->setName($parent["name"]);
                $familiar->setLastnames($parent["lastnames"]);
                $familiar->setChild($person);
                $person->addParent($familiar);
                $doctrine->getManager()->persist($familiar);
                continue;
            }
            $familiar = $doctrine->getRepository('App:Familiar')->findOneBy(['id' => $parent["id"]]);
            if($familiar->getChild()->getUser()->getId() != $user->getId()){
                return false;
            }
            $familiar->setName($parent["name"]);
            $familiar->setLastnames($parent["lastnames"]);
            $doctrine->getManager()->persist($familiar);
        }
        return true;
    }

    public function processChildren(Person $person, array $children, ManagerRegistry $doctrine, User $user) : bool{
        foreach($children as $child){
            if(!isset($child['id'])){
                $familiar = new Familiar();
                $familiar->setName($child["name"]);
                $familiar->setLastnames($child["lastnames"]);
                $familiar->setParent($person);
                $person->addChild($familiar);
            }
            else{
            $familiar = $doctrine->getRepository('App:Familiar')->findOneBy(['id' => $child["id"]]);
            if($familiar->getParent()->getUser()->getId() != $user->getId()){
                return false;
            }
            $familiar->setName($child["name"]);
            $familiar->setLastnames($child["lastnames"]);
            $doctrine->getManager()->persist($familiar);
            }
        }
        return true;
    }
}