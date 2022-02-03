<?php

namespace App\Controller\Rest;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\LabelService;

class LabelController extends AbstractFOSRestController{

    private $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    /**
     * @Rest\Get("/label/default")
     */
    public function getDefaultLabels(){
        $labels = $this->labelService->getDefaultLabels();
        return new JsonResponse($labels);
    }

    /**
     * @Rest\Get("/label/persons")
     */
    public function getPersonLabelsAction(){
       $labels = $this->labelService->getPersonLabels();
        return new JsonResponse($labels);
    }

    /**
     * @Rest\Get("/label/products")
     */
    public function getProductLabelsAction(){
         $labels = $this->labelService->getProductLabels();
          return new JsonResponse($labels);
    }

    /**
     * @Rest\Get("/label/notes")
     */
     public function getNoteLabelsAction(){
         $labels = $this->labelService->getNoteLabels();
         return new JsonResponse($labels);
     }
}

