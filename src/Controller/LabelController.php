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
    public function index(): JsonResponse
    {
        $labels = $this->labelService->getPersonLabels();
        return new JsonResponse($labels);

    }
}
