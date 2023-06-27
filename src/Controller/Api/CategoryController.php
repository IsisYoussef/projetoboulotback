<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/categories", name="app_api_category_")
     */
    public function browse(CategoryRepository $categoryRepository): JsonResponse
    {
        /**
        * categories list
        * @Route("/", name="browse")
        */
        $allCategories = $categoryRepository->findAll();

        return $this->json(
            $allCategories,
                200,
            [],
            [
                "groups" =>
                [
                    "category_browse"
                ]
            ]
            
        );
    }
}
