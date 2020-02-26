<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\AddCompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/companies", name="companies")
     */
    public function companies()
    {
        $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
        $user = $this->getUser();
        $idUser = $user->getId();
        $companies = $repositoryCompany->findByUser($idUser);
        $numberCompany = count($companies);
        $nmaxCompanies = $user->getCompanyLimit();
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
            'companies' => $companies,
            'numberCompanies' => $numberCompany,
            'nMaxComanies' => $nmaxCompanies
        ]);
    }





    /**
     * @Route("/showCompany", name="showCompany")
     */
    public function showCompany()
    {
        $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
        $user = $this->getUser();
        $idUser = $user->getId();
        $companies = $repositoryCompany->findCompaniesByUser($idUser);
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
            'companies' => $companies
        ]);
    }


    /**
     * @Route("/deleteCompany", name="deleteCompany")
     */
    public function deleteCompany()
    {
        if(isset($_GET['id'])) {
            $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
            $entityManager = $this->getDoctrine()->getManager();
            $company = $repositoryCompany->findOneCompanyById($_GET['id']);
            $status = FALSE;
            $company->setStatus($status);
            $entityManager->persist($company);
            $entityManager->flush();
            $user = $this->getUser();
            $idUser = $user->getId();
            $companies = $repositoryCompany->findByUser($idUser);
            $numberCompany = count($companies);
            $nmaxCompanies = $user->getCompanyLimit();
            return $this->render('company/index.html.twig', [
                'controller_name' => 'CompanyController',
                'companies' => $companies,
                'numberCompanies' => $numberCompany,
                'nMaxComanies' => $nmaxCompanies
            ]);
        }else{
            $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
            $user = $this->getUser();
            $idUser = $user->getId();
            $companies = $repositoryCompany->findByUser($idUser);
            return $this->render('company/index.html.twig', [
                'controller_name' => 'CompanyController',
                'companies' => $companies
            ]);
        }
    }


    /**
     * @Route("/addNewCompany", name="addNewCompany")
     */
    public function addNewCompany(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $newCompany = new Company();
        $form = $this->createForm(AddCompanyType::class, $newCompany);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $entityManager = $this->getDoctrine()->getManager();
            $newCompany->setStatus(true);
            $newCompany->setUser($this->getUser());
            $entityManager->persist($newCompany);
            $entityManager->flush();
        }
        return $this->render('form/addnewcompany.html.twig', [
            'controller_name' => 'CompanyController',
            'formulario' => $form->createView()
        ]);
    }


    /**
     * @Route("/editCompany", name="editCompany")
     */
    public function edit()
    {
        if (isset($_GET['id'])) {
            $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
            $user = $this->getUser();
            $idUser = $user->getId();
            $companies = $repositoryCompany->findCompaniesByUser($idUser);
            return $this->render('company/index.html.twig', [
                'controller_name' => 'CompanyController',
                'companies' => $companies
            ]);
        }
    }
}
