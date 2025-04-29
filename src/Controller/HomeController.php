<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        // V kontroleru můžete upravit $cartImage jako objekt místo pole.
$cartImage = [
    'name' => 'Cart',
    'image' => 'cart.png',  // Obrázek košíku
    'link' => 'app_cart',    // Odkaz na stránku košíku
    'alt' => 'Cart'         // Alternativní text
];

// Předání do šablony
return $this->render('eshop/home.html.twig', [
    'cartImage' => $cartImage,  // Předání proměnné do šablony
    'videoPath' => 'videos/video.mp4',
]);
    }
    #[Route('/contact', name: 'app_contact')]
public function contact(): Response
{
    return $this->render('contact/index.html.twig');
}

}
    