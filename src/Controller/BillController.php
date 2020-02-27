<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bill;
use App\Entity\Company;

class BillController extends AbstractController
{
    /*Vista de todas las facturas correspondientes a la empresa en la que se encuentra el usuario*/
    /**
     * @Route("/{id}/facturas", name="bill")
     */
    public function index($id)
    {		
    	if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $bill = $billRepository= $this->getDoctrine()->getRepository(Bill::class);
        $bill = $billRepository->findByIdCompany($id);

        return $this->render('bill/index.html.twig', [
            'controller_name' => 'BillController',
            'bill' => $bill
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
