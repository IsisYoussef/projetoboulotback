<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/backoffice", name="dashboard")
     */
    public function index(Request $request, UserInterface $userInterface): Response
    {
        
        return $this->render('backoffice/main/index.html.twig', [

        ]);
    }
}
