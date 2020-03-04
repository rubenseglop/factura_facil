<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddClientType;
use App\Form\EditClientType;

class ClientController extends AbstractController
{
    /* Main View */
    /**
     * @Route("/{id}/cliente", name="client")
     */
    public function index($id)
    {   
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }else{
            $entityManager = $this->getDoctrine()->getManager();
            $client = $repositoryClient= $this->getDoctrine()->getRepository(Client::class);
            $client = $repositoryClient->findByIdCompany($id);

            return $this->render('client/index.html.twig', [
                'controller_name' => 'ClientController',
                'client' => $client, 
                'company_id'=> $id
        ]);
        }
    }

  

    //Formulario para añadir nuevo cliente
    /**
     * @Route("{id}/cliente/agregar-nuevo-cliente", name="addNewClient")
     */
    public function addNewClient($id, Request $request){
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $client = new Client();
        $form = $this->createForm(AddClientType::class, $client);
        
        $entityManager = $this->getDoctrine()->getManager();
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
        $company = $repositoryCompany->findOneCompanyById($id);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $entityManager = $this->getDoctrine()->getManager();
            $client = $form->getData();
            $client->setStatus(true);
            $client->setCompany($company);
            
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirect('/'.$id.'/cliente/');
        }
        return $this->render('form/addnewclient.html.twig', [
             'registrationForm' =>$form->createView(),
             'client' => $client,
             'company_id'=> $id
             ]);
    }

    
    
    // Formulario para editar los datos del cliente
    /**
     * @Route("{id}/editar", name="editar")
     */
    public function edit($id, Request $request){
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
            return $this->redirect('/'.$client->getCompany()->getId().'/cliente/');
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
            'client' => $client,
            'company_id'=> $id
        ]);
    }


    // Buscador
    /**
     * @Route("/{id}/cliente/buscar", name="search")
     */
    public function search( $id){
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }else{
            $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
            //$client = $repositoryClient->findOneById($id);
            
            
            $client = $repositoryClient->searchClient($_POST['buscador'], $id);
            
            return $this->render('client/index.html.twig', [
                                 'controller_name' => 'ClientController',
                                 'client' => $client,
                                 'company_id'=> $id
                                ]);
            }
    }



    //Borrar Cliente
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteClient(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $repositoryClient = $this->getDoctrine()->getManager();
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        
        $client = $repositoryClient->findOneById($id);
        $client->setStatus(false);
        $em->persist($client);
        $em->flush();
        return $this->redirect('/'.$client->getCompany()->getId().'/cliente/'); 
    }




}
