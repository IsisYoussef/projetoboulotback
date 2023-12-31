<?php

namespace App\Controller\Back;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Datetime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mime\Email;

/**
 * @Route("/backoffice/job", name="app_back_job_")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(JobRepository $jobRepository): Response
    {
        return $this->render('backoffice/job/index.html.twig', [
            'jobs' => $jobRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, JobRepository $jobRepository, MailerInterface $mailerInterface): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobRepository->add($job, true);

        //---- Mail Mailgun -----
        
        $newMail = new Email();
        $newMail->from("admin@oboulot.io")
        ->to("isisyoussef24@gmail.com")
        ->subject("Une nouvelle offre est publiée")
        ->text("Découvrir cette super offre")
        ->html("<h1>Une nouvelle offre</h1>");

        $mailerInterface->send($newMail);

        // ----      ----

            return $this->redirectToRoute('app_back_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/job/new.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(?Job $job): Response
    {
        if ($job === null){throw $this->createNotFoundException("cette offre n'existe pas");}

        return $this->render('backoffice/job/show.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ?Job $job, JobRepository $jobRepository): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobRepository->add($job, true);

            return $this->redirectToRoute('app_back_job_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/job/edit.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Job $job, JobRepository $jobRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");

        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $jobRepository->remove($job, true);
        }

        return $this->redirectToRoute('app_back_job_index', [], Response::HTTP_SEE_OTHER);
    }
}
