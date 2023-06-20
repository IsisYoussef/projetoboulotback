<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * User's list
     * @Route("/api/users", name="app_user_", methods={"GET"})
     * @return JsonResponse
     */
    public function browse(UserRepository $userRepository): JsonResponse
    {
        $allUsers = $userRepository->findAll();

        return $this->json([
            $allUsers,
            200,
            [],
            [
                "groups" =>
                "user_browse"
            ]
        ]);
    }

    /**
     * Read User
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if ($user === null){
            return $this->json(
                [
                    "message" => "Ce user n'existe pas"
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            $user,
            200,
            [],
            [
                "groups" =>
                [
                    "user_read"
                ]
            ]
                );
    }
}
