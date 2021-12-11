<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller\Person;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class CreatePerson extends AbstractController
{

    public function __invoke(Person $data, ManagerRegistry $doctrine): Person
    {
        $em = $doctrine->getManager();
        $em->persist($data);
        $em->flush();

        return $data;
    }
}
