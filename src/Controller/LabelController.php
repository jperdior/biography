<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\LabelService;

class LabelController extends AbstractController
{

    private $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    #[Route('/api/people/labels', name: 'people_labels')]
    public function getPersonLabelsAction(): JsonResponse
    {
        $labels = $this->labelService->getPersonLabels();
        return new JsonResponse($labels);

    }

    #[Route('/api/ecommerce/labels', name: 'ecommerce_labels')]
    public function getEcommerceLabelsAction(): JsonResponse
    {
        $labels = $this->labelService->getProductLabels();
        return new JsonResponse($labels);

    }
}
