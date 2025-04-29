<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $cartImage = [
            'name' => 'Cart',
            'image' => 'cart.png',  // Obrázek košíku
            'link' => 'app_cart',    // Odkaz na stránku košíku
            'alt' => 'Cart'         // Alternativní text
        ];

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'cartImage' => $cartImage
        ]);
    }
}
