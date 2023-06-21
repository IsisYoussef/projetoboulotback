<?php

namespace App\Controller\Api;

use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("api/candidats", name="app_candidate_")
 */
class CandidateController extends AbstractController
{
    /**
     * Candidate's list
     * @Route("", name="browse", methods={"GET"})
     * @return JsonResponse
     */
    public function browse(CandidateRepository $candidateRepository): JsonResponse
    {
        $allCandidates = $candidateRepository->findAll();

        return $this->json(
            $allCandidates,
            200,
            [],
            [
                "groups" => 
                [
                    "candidate_browse"
                ]
            ]
        );
    }

    /**
     * Read Candidat
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, CandidateRepository $candidateRepository): JsonResponse
    {
        $candidate = $candidateRepository->find($id);

        if ($candidate === null){
            return $this->json(
                [
                    "message" => "Ce candidat n'existe pas"
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            $candidate,
            200,
            [],
            [
                "groups" =>
                [
                    "candidate_read"
                ]
            ]
                );
    }

    /**
     * Add Candidate
     * @Route("", name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        SerializerInterface $serializerInterface,
        CandidateRepository $candidateRepository,
        ValidatorInterface $validatorInterface,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ) 
    {
        $jsonContent = $request->getContent();
        try {
            $candidate = $serializerInterface->deserialize($jsonContent, Candidate::class, 'json');
        } catch (EntityNotFoundException $entityNotFoundException) {
            return $this->json("Denormalisation : " . $entityNotFoundException->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $errors = $validatorInterface->validate($candidate);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $plainPassword = $candidate->getPassword();

        $hashedPassword = $userPasswordHasherInterface->hashPassword($candidate, $plainPassword);

        $candidate->setPassword($hashedPassword);

        $candidateRepository->add($candidate, true);

        return $this->json($candidate, Response::HTTP_CREATED, [], ["groups"=>["candidate_read"]]);
    }

    /**
     * Edit Candidat
     * @Route("/{id}", name="edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, SerializerInterface $serializerInterface, CandidateRepository $candidateRepository)
    {
        $jsonContent = $request->getContent();

        $candidate = $candidateRepository->find($id);

        $serializerInterface->deserialize($jsonContent, Candidate::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $candidate]);

        $candidateRepository->add($candidate, true);

        return $this->json($candidate, Response::HTTP_OK, [], ["groups"=>["candidate_read","candidate_browse"]]);
    }

    /**
     * Delete Candidate
     * @Route("/{id}",name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, CandidateRepository $candidateRepository)
    {
        $candidate = $candidateRepository->find($id);
        $candidateRepository->remove($candidate, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
    * @Route("/me",name="me", methods={"GET"})
     *
     * @return void
     */
    public function getUserData()
    {
        /** @var App\Entity\Candidat  */
        $user = $this->getUser();

        //var_dump($user);
        return $this->json($user, 
    200,
[],
);
    }
}
