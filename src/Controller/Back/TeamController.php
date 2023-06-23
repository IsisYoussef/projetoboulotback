<?php

namespace App\Controller\Back;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/back/team", name="app_back_team")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $this->$userRepository->findByRole(["ROLE_ADMIN"]);
        return $this->render('back/team/index.html.twig', [
            "users" => $users
            
            //'users' => $userRepository->findBy(
               // ['roles' => "ROLE_USER", "ROLE_ADMIN", "ROLE_"]),
        ]);
    }
}
