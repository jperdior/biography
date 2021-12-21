<?php

namespace App\Controller\Family;

use App\Entity\Family;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Doctrine\Persistence\ManagerRegistry;

#[AsController]
class CreateFamily extends AbstractController
{

    public function __invoke(Family $data, ManagerRegistry $doctrine): Family
    {
        $user = $this->getUser();
        $data->setUser($user);
        $em = $doctrine->getManager();
        $em->persist($data);
        $em->flush();

        return $data;
    }
}
