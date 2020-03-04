<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bill;
use App\Entity\BillLine;
use App\Entity\Company;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddNewBillType;
use App\Form\EditBillType;

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
        $billRepository= $this->getDoctrine()->getRepository(Bill::class);
        
        if(isset($_POST['start-date']) && isset($_POST['end-date'])) {
            $bills = $billRepository->findByDateBill($_POST['start-date'], $_POST['end-date'], $id);
        }else if(isset($_POST['numberBill'])) {
            $bills = $billRepository->findByNumberBill($_POST['numberBill'],$id);
        }else if(isset($_POST['description'])){
            $bills = $billRepository->findByDescription($_POST['description'],$id);
        }else if(isset($_POST['client'])){
            $bills = $billRepository->findByClient($_POST['client'],$id);
        }else {
            $bills = $billRepository->findByIdCompany($id);
        }

        return $this->render('bill/index.html.twig', [
            'controller_name' => 'BillController',
            'bills' => $bills,
            'company_id' => $id
        ]);
    }
    //Formulario para añadir una nueva factura
    /**
     * @Route("{id}/nueva-factura", name="addNewBill")
     */
    public function addNewBill($id, Request $request){
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $bill = new Bill();
        $form = $this->createForm(AddNewBillType::class, $bill);
        
        $entityManager = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $billLineRepository = $this->getDoctrine()->getRepository(BillLine::class);
        $companyRepository = $this->getDoctrine()->getRepository(Company::class);

        $company = $companyRepository->findOneById($id);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){

            $entityManager = $this->getDoctrine()->getManager();
            $bill = $form->getData();
            $bill->setStatus(true);
            $bill->setCompany($company);
            $bill->setNumberBill(1221);

            foreach($bill->getBillLines() as $billLine) {
                $billLine->setBill($bill);
            }
            
            $entityManager->persist($bill);
            $entityManager->flush();
            return $this->redirect('/'.$bill->getCompany()->getId().'/facturas/');
        }
        return $this->render('form/addNewBill.html.twig', [
             'invoiceForm' =>$form->createView(),
             'bill' => $bill,
             'company_id' => $id,
        ]);
    }

    // Formulario para editar los datos de una factura
    /**
     * @Route("{id}/editBill", name="editBill")
     */
    public function edit($id, Request $request){
        $bill2 = new bill();
        $billLine2 = new billLine();
        $form = $this->createForm(EditBillType::class, $bill2);

        $entityManager = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $billLineRepository = $this->getDoctrine()->getRepository(BillLine::class);
        $companyRepository = $this->getDoctrine()->getRepository(Company::class);
        $bill = $billRepository->findOneById($id);
        $billLine = $billLineRepository->findByBill($bill->getId());

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            
            $entityManager = $this->getDoctrine()->getManager();
            $bill2 = $form->getData();

            if($bill2->getDescriptionBill() != $bill->getDescriptionBill() || $bill2->getDescriptionBill() != ""){
                $bill->setDescriptionBill($bill2->getDescriptionBill());
            }
            if($bill2->getClient() != $bill->getClient() || $bill2->getClient() != ""){
                $bill->setClient($bill2->getClient());
            }
            $entityManager->persist($bill);
            $entityManager->flush();
            return $this->redirect('/'.$bill->getCompany()->getId().'/facturas/');
        }
        return $this->render('form/editBill.html.twig', [ 
            'invoiceForm' =>$form->createView(),
            'bill' => $bill,
            'company_id' => $id, 
        ]);
    }

    //Función para cambiar el status de una factura de activo a inactivo
    /**
     * @Route("/borrar-factura/{id}", name="deleteBill")
     */
    public function deleteBill(Request $request, $id) {
        $entityManager = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        
        $bill = $billRepository->findOneById($id);
        $bill->setStatus(false);
        $entityManager->persist($bill);
        $entityManager->flush();
        return $this->redirect('/'.$bill->getCompany()->getId().'/facturas/'); 
    }

    /*Vista de la factura que el usuario haya seleccionado para visualizar*/
    /**
     * @Route("/factura/{id}", name="showBill")
     */
    public function showBill($id){
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $bill = $billRepository->findOneById($id);
        return $this->render('bill/bill.html.twig',[
            'controller_name'=> 'BillController',
            'bill' => $bill
        ]);
    }

    /**
     * Mostrar pdf de la factura seleccionada
     * @Route("/pdf-factura/{id}", name="showPdfBill")
     */
    public function showPdfBill($id) {
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $bill = $billRepository->findOneById($id);

        return $this->render('bill/pdf_bill.html.twig',[
            'bill' => $bill
        ]);
    }

}