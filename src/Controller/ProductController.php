<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchProductType;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {   

        $usuario=$this->getUser();
        $repositorioProductos=$this->getDoctrine()->getRepository(Product::class);
        $todosProductos=$repositorioProductos->findAll();
        
        

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'usuario' => $usuario,
            'productos'=>$todosProductos
            
        ]);
    }
    /**
     * @Route("/product/buscar", name="buscar")
     */
    public function search()
    {   
        /*
        $usuario=$this->getUser();
        $repositorioProductos=$this->getDoctrine()->getRepository(Product::class);
        */
        
        
        return $this->render('product/buscar.html.twig', [
            'controller_name' => 'ProductController'
            
        ]);
    }
}
