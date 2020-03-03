<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchProductType;
use App\Form\EditProductType;


class ProductController extends AbstractController
{
    /**
     * @Route("/{id}/product", name="product")
     */
    public function index($id)
    {  
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        //Compañía
        $companyRepository=$this->getDoctrine()->getRepository(Company::class);
        $company=$companyRepository->findOneBy(['id'=>$id,'User'=>$user]);
        //Productos
        $productRepository=$this->getDoctrine()->getRepository(Product::class);
        $products=$productRepository->findBy(['company'=>$company]);
        //Formulario
        if(isset($_POST['name'])){
            $productName=$_POST['name'];
            $product=$productRepository->findOneBy(['name'=>$productName,'company'=>$company]);
            return $this->render('product/search.html.twig', [
                'controller_name' => 'ProductController',
                'products' => $products,
                'id_company'=>$id,
                'product'=>$product

            ]);

        }else{
            return $this->render('product/index.html.twig', [
                'controller_name' => 'ProductController',
                'products' => $products,
                'id_company'=>$id

            ]);
        }
    }
    /**
     * @Route("{id}/product/add", name="add")
     */
    public function addProduct($id, Request $request)
    {   
        /*
        $usuario=$this->getUser();
        $repositorioProductos=$this->getDoctrine()->getRepository(Product::class);
        */
        $product=new Product();
        $form=$this->createForm(EditProductType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $product=$form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product');

        }
        
        return $this->render('product/add.html.twig', [
            'controller_name' => 'ProductController',
            'idCompany'=>$id,
            'form'=>$form->createView()
            
        ]);
    }
    /**
    * @Route("{id}/product/editProduct/{idProduct}", name="editProduct")
    */
    public function editProduct($idProduct,Request $request,$id)
    {   
      
        $productRepository=$this->getDoctrine()->getRepository(Product::class);
        $product=$productRepository->find($idProduct);
        $form=$this->createForm(EditProductType::class,$product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $product=$form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product');

        }
        
        return $this->render('product/editProduct.html.twig', [
            'controller_name' => 'ProductController',
            'idCompany'=>$id,
            'form'=>$form->createView()
            
        ]);
    }

    /**
    * @Route("{id}/product/deleteProduct/{idProduct}", name="deleteProduct")
    */
    public function deleteProduct($idProduct,Request $request,$id)
    {   
      
        $productRepository=$this->getDoctrine()->getRepository(Product::class);
        $product=$productRepository->find($idProduct);
        $form=$this->createForm(EditProductType::class,$product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $product=$form->getData();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product');

        }
        
        return $this->render('product/editProduct.html.twig', [
            'controller_name' => 'ProductController',
            'idCompany'=>$id,
            'form'=>$form->createView()
            
        ]);
    }
}
