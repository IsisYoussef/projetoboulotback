<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TeamController extends AbstractController
{
    /**
     * @Route("/back/team", name="app_back_team_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findByRole(['ROLE_MANAGER', 'ROLE_USER', 'ROLE_ADMIN']);
     
        return $this->render('back/team/index.html.twig', [
            "users" => $users
            
        ]);
    }

    /**
     * @Route("back/team/new", name="app_back_team_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/team/new.html.twig', [
            'team' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("back/team/{id}", name="app_back_team_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('back/team/show.html.twig', [
            'team' => $user,
        ]);
    }

    /**
     * @Route("back/team/{id}/edit", name="app_back_team_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_back_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/team/edit.html.twig', [
            'team' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("back/team/{id}/delete", name="app_back_team_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_back_team_index', [], Response::HTTP_SEE_OTHER);
    }

}
