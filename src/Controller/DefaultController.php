<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class DefaultController extends AbstractController
{

    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/{_locale}/{vueRouting}",
     *  name="index",
     *  defaults={"_locale": "es", "vueRouting": null},
     * requirements={"_locale": "|es|en","vueRouting"="^(?!api|_(profiler|wdt)).*"})
     * @return Response
     */
    public function indexAction(): Response
    {
        $user = $this->getUser();
        $data = null;
        if (! empty($user)) {
            $userClone = clone $user;
            $userClone->setPassword('');
            $data = $this->serializer->serialize($userClone, JsonEncoder::FORMAT,['groups'=>['user:read'],  'circular_reference_handler'=> function($object){
            return $object->getId();
        }]);
        }
        return $this->render('admin/index.html.twig', [
            'isAuthenticated' => json_encode(! empty($user)),
            'user' => $data ?? json_encode($data),
        ]);
    }


    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/frontend', name: 'frontend')]
    public function frontend(): Response
    {
        return $this->render('frontend/index.html.twig');
    }
}
