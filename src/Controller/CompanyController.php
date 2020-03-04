<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\SocialNetworks;
use App\Form\AddCompanyType;
use App\Form\EditCompanyType;
use App\Form\SocialNetworksType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/empresas", name="companies")
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
     * @Route("/addSocialNetworks", name="addSocialNetworks")
     */
    public function socialNetworks(Request $request):Response
    {
        if (isset($_GET['id'])) {
            $socialnetwork = new SocialNetworks();
            $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
            $company = $repositoryCompany->findOneCompanyById($_GET['id']);
            $form = $this->createForm(SocialNetworksType::class, $socialnetwork);
            //$form->handleRequest($request);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $company = $form->getData();
                $company->setName($company->getName());
                $company->setFiscalAddress($company->getFiscalAddress());
                $company->setEmail($company->getEmail());
                $company->setNIF($company->getNIF());
                $entityManager->persist($company);
                $entityManager->flush();
                return $this->redirectToRoute('companies');
            }
            return $this->render('company/editCompany.html.twig', [
                'editCompany_form' => $form->createView(),
                'controller_name' => 'CompanyController',
                'companies' => $company,
                'nameCompany' => $nameCompany,
                'fiscalAdressCompany' => $fiscalAdressCompany,
                'emailCompany' => $emailCompany,
                'nifCompany' => $nifCompany,
                'socialNetworks' => $socialNetworks
            ]);
        }
    }



    /**
     * @Route("/{id}/empresa", name="showCompany")
     */
    public function showCompany($id)
    {
        
        $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
        $user = $this->getUser();
        $idUser = $user->getId();
        $company = $repositoryCompany->findOneCompanyById($id);
        return $this->render('company/showCompany.html.twig', [
            'controller_name' => 'CompanyController',
            'company' => $company,
            'company_id' => $id
        ]);
    }

    /**
     * @Route("/editar-empresa", name="editCompany")
     */
    public function edit(Request $request)
    {
        if (isset($_GET['id'])) {
            $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
            $company = $repositoryCompany->findOneCompanyById($_GET['id']);
            $nameCompany = $company->getName();
            $fiscalAdressCompany = $company->getFiscalAddress();
            $emailCompany = $company->getEmail();
            $nifCompany = $company->getNIF();
            $socialNetworks = $company->getSocialNetworks();
            $form = $this->createForm(EditCompanyType::class, $company);
            //$form->handleRequest($request);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $company = $form->getData();
                $company->setName($company->getName());
                $company->setFiscalAddress($company->getFiscalAddress());
                $company->setEmail($company->getEmail());
                $company->setNIF($company->getNIF());
                $entityManager->persist($company);
                $entityManager->flush();
                return $this->redirectToRoute('companies');
            }
            return $this->render('company/editCompany.html.twig', [
                'editCompany_form' => $form->createView(),
                'controller_name' => 'CompanyController',
                'companies' => $company,
                'nameCompany' => $nameCompany,
                'fiscalAdressCompany' => $fiscalAdressCompany,
                'emailCompany' => $emailCompany,
                'nifCompany' => $nifCompany,
                'socialNetworks' => $socialNetworks
            ]);
        }
    }

    /**
     * @Route("/borrar-empresa", name="deleteCompany")
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
     * @Route("/agregar-empresa", name="addNewCompany")
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
            return $this->redirectToRoute('companies');
        }
        return $this->render('form/addnewcompany.html.twig', [
            'controller_name' => 'CompanyController',
            'editCompany_form' => $form->createView()
        ]);
    }
}
