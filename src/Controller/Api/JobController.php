<?php

namespace App\Controller\Api;

use App\Entity\Job;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/offres", name="app_api_jobs_")
 */
class JobController extends AbstractController
{
    /**
     * Job's list
     * @Route("/", name="browse")
     */
    public function browse(JobRepository $jobRepository): JsonResponse
    {
        // Job's list
        $allJobs = $jobRepository->findAll();

        return $this->json([
            $allJobs,
            200,
            [],
            [
                "groups" =>
                [
                    "job_browse"
                ]
            ]
        ]);
    }

    /**
     * Read Job
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, JobRepository $jobRepository): JsonResponse
    {
        $job = $jobRepository->find($id);

        if ($job === null){
            return $this->json(
                [
                    "message" => "Cette offre n'existe pas"
                ],
                Response::HTTP_NOT_FOUND
            );
        }
        
        return $this->json(
            $job,
            200,
            [],
            [
        "groups" =>
        [
            "job_read"
        ]
    ]
        );
    }

    /**
     * Add Job
     * @Route("",name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        SerializerInterface $serialiserInterface,
        JobRepository $jobRepository,
        ValidatorInterface $validatorInterface
    ) {
        $jsonContent = $request->getContent();
        try {
            $job = $serialiserInterface->deserialize($jsonContent, Job::class, 'json');
        } catch (EntityNotFoundException $entityNotFoundException) {
            return $this->json("Denormalisation : " . $entityNotFoundException->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $errors = $validatorInterface->validate($job);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $jobRepository->add($job, true);

        return $this->json($job, Response::HTTP_CREATED, [], ["groups"=>["job_read"]]);
    }

    /**
     * Edit Job
     * @Route("/{id}", name="edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, SerializerInterface $serialiserInterface, JobRepository $jobRepository)
    {
        $jsonContent = $request->getContent();

        $job = $jobRepository->find($id);

        $serialiserInterface->deserialize($jsonContent, Job::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $job]);

        $jobRepository->add($job, true);

        return $this->json($job, Response::HTTP_OK, [], ["groups"=>["job_read","job_browse"]]);

    }

    /**
     * Delete Job
     * @Route("/{id}",name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, JobRepository $jobRepository)
    {
        $job = $jobRepository->find($id);
        $jobRepository->remove($job, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

}