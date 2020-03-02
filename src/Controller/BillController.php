<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bill;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddNewBillType;

class BillController extends AbstractController
{
    /*Vista de todas las facturas correspondientes a la empresa en la que se encuentra el usuario*/
    /**
     * @Route("/{id}/facturas", name="bills")
     */
    public function index($id)
    {		
    	if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $bills = $billRepository= $this->getDoctrine()->getRepository(Bill::class);
        $bills = $billRepository->findByIdCompany($id);

        return $this->render('bill/index.html.twig', [
            'controller_name' => 'BillController',
            'bills' => $bills
        ]);
    }
    //Formulario para añadir una nueva factura
    /**
     * @Route("{id}/nuevaFactura", name="addNewBill")
     */
    public function addNewBill($id, Request $request){
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $bill = new Bill();
        $form = $this->createForm(AddNewType::class, $bill);
        
        $entityManager = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $repositoryCompany = $this->getDoctrine()->getRepository(Company::class);
        $company = $repositoryCompany->findOneById($id);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $entityManager = $this->getDoctrine()->getManager();
            $bill = $form->getData();
            $bill->setStatus(true);
            $bill->setCompany($company);
            
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirect('/'.$id.'/factura/');
        }
        return $this->render('form/addNewBill.html.twig', [
             'registrationForm' =>$form->createView(),
             'bill' => $bill
             ]);
    }
    //Función para cambiar el status de una factura de activo a inactivo
    /**
     * @Route("/borrarFactura/{id}", name="deleteBill")
     */
    public function deleteBill(Request $request, $id){
        $entityManager = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        
        $bill = $billRepository->findOneById($id);
        $bill->setStatus(false);
        $entityManager->persist($bill);
        $entityManager->flush();
        return $this->redirect('/'.$bill->getCompany()->getId().'/facturas/'); 
    }
    // Buscador de factura por fecha
    /**
     * @Route("/busqueda", name="searchDate")
     */
    public function searchBill(Request $request){
        $bills = $billRepository= $this->getDoctrine()->getRepository(Bill::class);
        $bills = $billRepository->findByDateBill($request);
        return $this->render('bill/index.html.twig', [
         'controller_name' => 'BillController',
         'bills' => $bills
         ]);
     }
    /*Vista de la factura que el usuario haya seleccionado para visualizar*/
    /**
     * @Route("/factura/{id}", name="showBill")
     */
    public function show($id){
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $bill = $billRepository->findOneById($id);
        return $this->render('bill/bill.html.twig',[
            'controller_name'=> 'BillController',
            'bill' => $bill
        ]);
    }
}
