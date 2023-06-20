<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\CandidateRepository;
use App\Repository\UserRepository;
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
 * @Route("api/users", name="app_user_")
 */
class UserController extends AbstractController
{
    /**
     * User's list
     * @Route("", name="browse", methods={"GET"})
     * @return JsonResponse
     */
    public function browse(UserRepository $userRepository): JsonResponse
    {
        $allUsers = $userRepository->findAll();

        return $this->json(
            $allUsers,
            200,
            [],
            [
                "groups" =>
                "user_browse"
            ]
        );
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

    /**
     * Add User
     * @Route("", name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        SerializerInterface $serializerInterface,
        UserRepository $userRepository,
        ValidatorInterface $validatorInterface,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ) 
    {
        $jsonContent = $request->getContent();
        try {
            $user = $serializerInterface->deserialize($jsonContent, User::class, 'json');
        } catch (EntityNotFoundException $entityNotFoundException) {
            return $this->json("Denormalisation : " . $entityNotFoundException->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $errors = $validatorInterface->validate($user);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $plainPassword = $user->getPassword();

        $hashedPassword = $userPasswordHasherInterface->hashPassword($user, $plainPassword);

        $user->setPassword($hashedPassword);

        $userRepository->add($user, true);

        return $this->json($user, Response::HTTP_CREATED, [], ["groups"=>["candidate_read"]]);
    }

    /**
     * Edit User
     * @Route("/{id}", name="edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, SerializerInterface $serializerInterface, UserRepository $userRepository)
    {
        $jsonContent = $request->getContent();

        $user = $userRepository->find($id);

        $serializerInterface->deserialize($jsonContent, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        $userRepository->add($user, true);

        return $this->json($user, Response::HTTP_OK, [], ["groups"=>["candidate_read","candidate_browse"]]);
    }

    /**
     * Delete User
     * @Route("/{id}",name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        $userRepository->remove($user, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
    * @Route("/me",name="me", methods={"GET"})
     *
     * @return void
     */
    public function getUserData()
    {
        /** @var App\Entity\User  */
        $user = $this->getUser();

        return $this->json($user, 
    200,
[],
);
    }

}

