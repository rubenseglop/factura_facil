<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/companies", name="companies")
     */
    public function companies()
    {
        $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
        $companies = $repositoryPosts->findOneById($_GET['idC']);
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }

    /**
     * @Route("/myCompanies", name="mYCompanies")
     */
    public function mycompanys()
    {
        
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }
}
