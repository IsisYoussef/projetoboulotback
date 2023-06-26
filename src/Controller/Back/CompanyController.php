<?php

namespace App\Controller\Back;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Datetime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/backoffice/company", name="app_back_company_")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * 

     */
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('backoffice/company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->add($company, true);

            return $this->redirectToRoute('app_back_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(?Company $company): Response
    {
        if ($company === null){throw $this->createNotFoundException("cette entreprise n'existe pas");}

        return $this->render('backoffice/company/show.html.twig', [
            'company' => $company,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ?Company $company, CompanyRepository $companyRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->add($company, true);

            return $this->redirectToRoute('app_back_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backoffice/company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, ?Company $company, CompanyRepository $companyRepository): Response
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");

        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $companyRepository->remove($company, true);
        }

        return $this->redirectToRoute('app_back_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
