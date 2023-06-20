<?php

namespace App\Controller\Api;

use App\Entity\Company;
use App\Repository\CompanyRepository;
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
 * @Route("/api/entreprises", name="app_api_company_")
 */
class CompanyController extends AbstractController
{
    /**
     * Companies list
     * @Route("/", name="browse")
     * @param CompanyRepository $companyRepository
     * @return JsonResponse
     */
    public function browse(CompanyRepository $companyRepository): JsonResponse
    {
        $allCompanies = $companyRepository->findAll();

        return $this->json(
            $allCompanies,
            200,
            [],
            [
                "groups" =>
                [
                    "company_browse"
                ]
            ]
        );
    }

    /**
     * Read Company
     * @Route("/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function read($id, CompanyRepository $companyRepository): JsonResponse
    {
        $company = $companyRepository->find($id);

        if ($company === null){
            return $this->json(
                [
                    "message" => "Cette entreprise n'existe pas"
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            $company,
            200,
            [],
            [
                "groups" =>
                [
                    "company_read"
                ]
            ]
                );
    }

    /**
     * Add Company
     * @Route("",name="add", methods={"POST"})
     */
    public function add(
        Request $request,
        SerializerInterface $serializerInterface,
        CompanyRepository $companyRepository,
        ValidatorInterface $validatorInterface
    ) {
        $jsonContent = $request->getContent();
        try {
            $company = $serializerInterface->deserialize($jsonContent, Company::class, 'json');
        } catch (EntityNotFoundException $entityNotFoundException) {
            return $this->json("Denormalisation : " . $entityNotFoundException->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $errors = $validatorInterface->validate($company);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_CREATED, [], ["groups"=>["company_read"]]);
        }

        $companyRepository->add($company, true);

        return $this->json($company, Response::HTTP_CREATED, [], ["groups"=>["company_read"]]);
    }

    /**
     * Edit Company
     * @Route("/{id}", name="edit", requirements={"id"="\d+"}, methods={"PUT", "PATCH"})
     */
    public function edit($id, Request $request, SerializerInterface $serialiserInterface, CompanyRepository $companyRepository)
    {
        $jsonContent = $request->getContent();

        $company = $companyRepository->find($id);

        $serialiserInterface->deserialize($jsonContent, Company::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $company]);

        $companyRepository->add($company, true);

        return $this->json($company, Response::HTTP_OK, [], ["groups"=>["company_read","company_browse"]]);

    }

    /**
     * Delete Company
     * @Route("/{id}",name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete($id, CompanyRepository $companyRepository)
    {
        $company = $companyRepository->find($id);
        $companyRepository->remove($company, true);

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
    * @Route("/me",name="me", methods={"GET"})
     *
     * @return void
     */
    public function getUserData()
    {
        /** @var App\Entity\Company  */
        $user = $this->getUser();

        return $this->json($user, 
    200,
[],
);
    }
}
