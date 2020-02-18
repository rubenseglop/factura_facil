<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddClientType;
use App\Form\EditClientType;

class ClientController extends AbstractController
{
    /* Main View */
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


    /* Al pinchar en el ícono editClient te lleva la vista donde se podrán editar los datos del cliente */ 
    /**
     * @Route("/editclient/{idclient}", name="editclient")
     */
    public function editClient($idclient){
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        $clients = $repositoryClient->findOneById($idclient);
        return $this->render('client/editarCliente.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clients
        ]);
    }


    //Al pinchar en el ícono addClient te lleva la vista donde se podrá añadir un cliente nuevo
    /**
     * @Route("/addClient", name="addClient")
     */
    public function addClient(){
        return $this->render('client/editarCliente.html.twig', [
            'controller_name' => 'ClientController'
        ]);
    }

  

    //Formulario para añadir nuevo cliente
    /**
     * @Route("/addNewClient", name="addNewClient")
     */
    public function addNewClient(Request $request){
        $client = new Client();
        $form = $this->createForm(AddClientType::class, $client);

        $entityManager = $this->getDoctrine()->getManager();
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        // $client = $repositoryClient->findOneById($idclient);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $entityManager = $this->getDoctrine()->getManager();
            $client = $form->getData();
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirect('/client/');
        }
        return $this->render('form/addnewclient.html.twig', [ 'registrationForm' =>$form->createView() ]);
    }

    
    // Formulario para editar los datos del cliente
    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, $id){
        $client2 = new Client();
        $form = $this->createForm(EditClientType::class, $client2);

        $entityManager = $this->getDoctrine()->getManager();
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        $client = $repositoryClient->findOneById($id);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            
            $entityManager = $this->getDoctrine()->getManager();
            $client2 = $form->getData();

            if($client2->getName() != $client->getName() && $client2->getName() != ""){
                $client->setName($client2->getName());
            }
            if($client2->getFiscalAdress() != $client->getFiscalAdress() && $client2->getFiscalAdress() != ""){
                $client->setFiscalAdress($client2->getFiscalAdress());
            }
            if($client2->getNIF() != $client->getNIF() && $client2->getNIF() != ""){
                $client->setNIF($client2->getNIF());
            }
            if($client2->getEmail() != $client->getEmail() && $client2->getEmail() != ""){
                $client->setEmail($client2->getEmail());
            }
            if($client2->getPhone() != $client->getPhone() && $client2->getPhone() != ""){
                $client->setPhone($client2->getPhone());
            }
            if($client2->getWeb() != $client->getWeb() && $client2->getWeb() != ""){
                $client->setWeb($client2->getWeb());
            }
            if($client2->getBossName() != $client->getBossName() && $client2->getBossName() != ""){
                $client->setBossName($client2->getBossName());
            }
            if($client2->getBossPhone() != $client->getBossPhone() && $client2->getBossPhone() != ""){
                $client->setBossPhone($client2->getBossPhone());
            }

            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirect('/client/');
        }
        return $this->render('form/editclient.html.twig', [ 'registrationForm' =>$form->createView() ]);
    }

    // Mostrar los datos de solo un cliente
    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id){
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        $client = $repositoryClient->findOneById($id);
        return $this->render('client/client.html.twig',[
            'controller_name'=> 'ClientController',
            'client' => $client
        ]);
    }


    // Buscador
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request){
       $repositoryClient = $this->getDoctrine()->getManager();
       $client = $repositoryClient->findByName();
       return $this->render('client/index.html.twig', [
        'controller_name' => 'ClientController',
        'client' => $client
        ]);
    }





}
