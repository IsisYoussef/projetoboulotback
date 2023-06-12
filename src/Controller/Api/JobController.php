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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/jobs", name="app_api_jobs_")
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
        return $this->json($job, 200, [], 
    [
        "groups" =>
        [
            "job_read"
        ]
    ]);
    }

    /**
     * Add Job
     * @Route("",name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        SerializerInterface $serialiserInterface,
        JobRepository $jobRepository,
        ValidatorInterface $validatorInterface)
    {
        $jsonContent = $request->getContent();
        try {
            $job = $serialiserInterface->deserialize($jsonContent, Job::class, 'json');
        } catch (EntityNotFoundException $entityNotFoundException){
            return $this->json("Denormalisation : " . $entityNotFoundException->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $errors = $validatorInterface->validate($job);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $jobRepository->add($job, true);

        return $this->json($job, Response::HTTP_CREATED, [], ["groups"=>["job_read"]]);
    }
    
    


}
