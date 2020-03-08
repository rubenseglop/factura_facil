<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bill;
use App\Entity\BillLine;
use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddNewBillType;
use Symfony\Component\HttpFoundation\Response;

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

        $total = false;
        
        if(isset($_POST['start-date']) && isset($_POST['end-date'])) {
            $bills = $billRepository->findByDateBill($_POST['start-date'], $_POST['end-date'], $id);
            $total = true;
        }else if(isset($_POST['numberBill'])) {
            $bills = $billRepository->findByNumberBill($_POST['numberBill'],$id);
            $total = true;
        }else if(isset($_POST['description'])) {
            $bills = $billRepository->findByDescription($_POST['description'],$id);
            $total = true;
        }else if(isset($_POST['client'])) {
            $bills = $billRepository->findByClient($_POST['client'],$id);
            $total = true;
        }else {
            $bills = $billRepository->findByIdCompany($id);
            $total = false;
        }

        return $this->render('bill/index.html.twig', [
            'controller_name' => 'BillController',
            'bills' => $bills,
            'company_id' => $id,
            'total' => $total
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

        $invoice = new Bill();
        $form = $this->createForm(AddNewBillType::class, $invoice);
        
        $entityManager = $this->getDoctrine()->getManager();
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $billLineRepository = $this->getDoctrine()->getRepository(BillLine::class);
        $companyRepository = $this->getDoctrine()->getRepository(Company::class);
        $repositoryClient= $this->getDoctrine()->getRepository(Client::class);
        $productRepository=$this->getDoctrine()->getRepository(Product::class);

        $company = $companyRepository->findOneBy(['id'=>$id, 'User'=>$this->getUser()]);
        $products = $productRepository->findBy(['company'=>$company, 'status'=>true]);
        $clients = $repositoryClient->findBy(['company'=>$company, 'status'=>true]);
        $last_invoice = $billRepository->findOneBy(['company' => $company, "numberBill" => $company->getInvoiceNumber()]);

        if($last_invoice != null) {
            $last_date = $last_invoice->getDateBill();
        }else {
            $last_date = null;
        }

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){

            $entityManager = $this->getDoctrine()->getManager();
            $invoice = $form->getData();

            $invoice->setStatus(true);
            $invoice->setCompany($company);
            $invoice->setNumberBill($company->getInvoiceNumber() + 1);
            $company->setInvoiceNumber($company->getInvoiceNumber() + 1);

            foreach($invoice->getBillLines() as $billLine) {
                $billLine->setBill($invoice);
            }
            
            $entityManager->persist($company);
            $entityManager->persist($invoice);
            $entityManager->flush();
            return $this->redirect('/'.$invoice->getCompany()->getId().'/facturas/');
        }
        return $this->render('form/invoice_form.html.twig', [
             'invoiceForm' =>$form->createView(),
             'company_id' => $id,
             'products' => $products,
             'clients' => $clients,
             'title' => "Añadir Nueva Factura",
             'send' => "Crear factura",
             'last_date' => $last_date
        ]);
    }

    // Formulario para editar los datos de una factura
    /**
     * @Route("{id}/editar-factura/{invoice_id}", name="editBill")
     */
    public function edit($id, Request $request, $invoice_id){

        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $companyRepository = $this->getDoctrine()->getRepository(Company::class);
        $repositoryClient = $this->getDoctrine()->getRepository(Client::class);
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $billLineRepository = $this->getDoctrine()->getRepository(BillLine::class);
        
        $company = $companyRepository->findOneBy(['id'=>$id,'User'=>$this->getUser()]);
        $products = $productRepository->findBy(['company'=>$company,'status'=>true]);
        $clients = $repositoryClient->findBy(['company'=>$company, 'status'=>true]);
        $invoice = $billRepository->findOneById($invoice_id);
        $invoice_lines = $billLineRepository->findBy(['bill' => $invoice]);
        
        $form = $this->createForm(AddNewBillType::class, $invoice);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){

            $entityManager = $this->getDoctrine()->getManager();

            $invoice = $form->getData();

            foreach($invoice->getBillLines() as $billLine) {
                if($billLine->getId() == null) {
                    $billLine->setBill($invoice);
                }
            }

            $entityManager->persist($invoice);
            $entityManager->flush();
            return $this->redirect('/'.$invoice->getCompany()->getId().'/facturas/');
        }

        foreach($invoice->getBillLines() as $billLine) {
            $invoice->removeBillLine($billLine);
        }

        return $this->render('form/invoice_form.html.twig', [ 
            'invoiceForm' =>$form->createView(),
            'company_id' => $id,
            'products' => $products,
            'clients' => $clients,
            'invoice' => $invoice,
            'invoice_lines' => $invoice_lines,
            'title' => "Editar Factura - Nº ".$invoice->getNumberBill(),
            'send' => "Actualizar"
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

    /**
     * @Route("/pdf-factura/{id}/detalle-factura", name="getInvoiceDetail")
     */
    public function getInvoiceDetail($id) {
        $billRepository = $this->getDoctrine()->getRepository(Bill::class);
        $invoice = $billRepository->findOneById($id);

        $company = $invoice->getCompany();
        $client = $invoice->getClient();

        if($client != null) {
            $response = new Response();
            $response->setContent(json_encode(array(
                'invoice_number' => $invoice->getNumberBill(),
                'invoice_date' => $invoice->getDateBill(),
                'invoice_description' => $invoice->getDescriptionBill(),
                'invoice_amount_iva' => $invoice->getAmountIVA(),
                'invoice_amount_without_iva' => $invoice->getAmountWithoutIVA(),
                'invoice_total_amount' => $invoice->getTotalInvoiceAmount(),
                'company_name' => $company->getName(),
                'company_fiscalAddress' => $company->getFiscalAddress(),
                'company_email' => $company->getEmail(),
                'company_nif' => $company->getNIF(),
                'client_name' => $client->getName(),
                'client_nif' => $client->getNIF(),
                'client_email' => $client->getEmail(),
                'client_phone' => $client->getPhone(),
                'client_web' => $client->getWeb(),
                'company_fiscal_adress' => $client->getFiscalAdress()
            )));
        }else {
            $response = new Response();
            $response->setContent(json_encode(array(
                'invoice-date' => $invoice->getDateBill(),
                'invoice-description' => $invoice->getDescriptionBill(),
                'invoice-amount_iva' => $invoice->getAmountIVA(),
                'invoice-amount_without_iva' => $invoice->getAmountWithoutIVA(),
                'invoice-total_amount' => $invoice->getTotalInvoiceAmount(),
            )));
        }
        

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * 
     * @Route("{id}/nueva-factura/linea-producto/{id_product}", name="getProductLine")
     */
    public function getProductLine($id, $id_product) {

        $companyRepository = $this->getDoctrine()->getRepository(Company::class);
        $productRepository=$this->getDoctrine()->getRepository(Product::class);

        $company = $companyRepository->findOneBy(['id'=>$id,'User'=>$this->getUser()]);
        $products = $productRepository->findBy(['company'=>$company,'status'=>true]);

        foreach($products as $product) {
            if($product->getId() == $id_product) {
                $response = new Response();
                $response->setContent(json_encode(array(
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'iva' => $product->getProductIVA(),
                    'price' => $product->getPrice(),
                )));
            }
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * 
     * @Route("{id}/editar-factura/{invoice_id}/linea-producto/{id_product}", name="getProductLine2")
     */
    public function getProductLine2($id, $id_product) {

        $companyRepository = $this->getDoctrine()->getRepository(Company::class);
        $productRepository=$this->getDoctrine()->getRepository(Product::class);

        $company = $companyRepository->findOneBy(['id'=>$id,'User'=>$this->getUser()]);
        $products = $productRepository->findBy(['company'=>$company,'status'=>true]);

        foreach($products as $product) {
            if($product->getId() == $id_product) {
                $response = new Response();
                $response->setContent(json_encode(array(
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'iva' => $product->getProductIVA(),
                    'price' => $product->getPrice(),
                )));
            }
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * 
     * @Route("{id}/editar-factura/{invoice_id}/borrar-linea-producto/{id_invoice_line}", name="removeInvoiceLine")
     */
    public function removeInvoiceLine($id_invoice_line, $invoice_id) {

        $billLineRepository = $this->getDoctrine()->getRepository(BillLine::class);
        
        $invoice_line = $billLineRepository->findById($id_invoice_line);

        $response = new Response();

        if($invoice_line != null) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($invoice_line);
            $entityManager->flush();
           
            $response->setContent(json_encode(array(
                'result' => 'ok'
            )));
        }else {
            $response->setContent(json_encode(array(
                'result' => 'error'
            )));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}