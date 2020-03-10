<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Entity\Company;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BudgetController extends AbstractController
{
    /**
     * @Route("/{id}/presupuestos", name="budgets")
     */
    public function index($id)
    {		
    	if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $budgetRepository= $this->getDoctrine()->getRepository(Budget::class);
        $companyRepository = $this->getDoctrine()->getRepository(Company::class);

        $company = $companyRepository->findOneBy(['id'=>$id, 'User'=>$this->getUser()]);
        $budgets = $budgetRepository->findBy(['company'=>$company, 'status'=>true]);

        return $this->render('budget/budgets.html.twig', [
            'company_id' => $id,
            'budgets' => $budgets
        ]);
    }

    /**
     * @Route("{id}/nuevo-presupuesto", name="addBudget")
     */
    public function addBudget($id, Request $request){
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
     * @Route("{id}/editar-presupuesto/{budget_id}", name="editBudget")
     */
    public function editBudget($id, Request $request, $budget_id){

        return $this->render('form/invoice_form.html.twig', [ 
            'company_id' => $id,
            'send' => "Actualizar"
        ]);
    }

    //Función para cambiar el status de una factura de activo a inactivo
    /**
     * @Route("/borrar-presupuesto/{id}", name="deleteBudget")
     */
    public function deleteBudget(Request $request, $id) {
        return $this->redirect('/231/facturas/');
    }
}
