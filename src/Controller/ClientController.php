<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index()
    {
       
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        $clients = $repositoryClient->findAll();
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clients
        ]);
    }


    /**
     * @Route("/searchClient/{val}", name="searchClient")
     */
    public function searchClient($val){

    }


}
