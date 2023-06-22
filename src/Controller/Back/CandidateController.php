<?php

namespace App\Controller\Back;

use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/candidate", name="app_back_candidate_")
 */
class CandidateController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     *
     */
    public function index(CandidateRepository $candidateRepository): Response
    {
        return $this->render('back/candidate/index.html.twig', [
            'candidates' => $candidateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, CandidateRepository $candidateRepository): Response
    {
        $candidate = new Candidate();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->add($candidate, true);

            return $this->redirectToRoute('app_back_candidate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Candidate $candidate): Response
    {
        if ($candidate === null) {
            throw $this->createNotFoundException("ce candidat n'existe pas");
        }

        return $this->render('back/candidate/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");
        
        if ($candidate === null) {
            throw $this->createNotFoundException("ce candidat n'existe pas");
        }

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->add($candidate, true);

            return $this->redirectToRoute('app_back_candidate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/candidate/edit.html.twig', [
                'candidate' => $candidate,
                'form' => $form,
            ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, ?Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");

        if ($candidate === null) {
            throw $this->createNotFoundException("ce candidat n'existe pas");
        }
        if ($this->isCsrfTokenValid('delete'.$candidate->getId(), $request->request->get('_token'))) {
            $candidateRepository->remove($candidate, true);
        }

        return $this->redirectToRoute('app_back_candidate_index', [], Response::HTTP_SEE_OTHER);
    }
}
