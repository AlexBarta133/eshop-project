<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session): Response
    {
        // Načtení aktuálního obsahu košíku
        $cart = $session->get('cart', []);

        // Vypočítání celkové ceny
        $totalPrice = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
        $cartImage = [
            'name' => 'Cart',
            'image' => 'cart.png',  // Obrázek košíku
            'link' => 'app_cart',    // Odkaz na stránku košíku
            'alt' => 'Cart'         // Alternativní text
        ];

        // Vykreslení stránky košíku
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
            'cartImage' => $cartImage
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add(int $id, SessionInterface $session, ProductRepository $productRepository): Response
    {
        // Načtení aktuálního obsahu košíku
        $cart = $session->get('cart', []);

        // Načtení produktu podle ID
        $product = $productRepository->find($id);

        // Pokud produkt existuje, přidáme jej do košíku nebo aktualizujeme množství
        if ($product) {
            $cart[$id] = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'quantity' => ($cart[$id]['quantity'] ?? 0) + 1,
            ];
        }

        // Uložení aktualizovaného košíku zpět do relace
        $session->set('cart', $cart);

        // Přesměrování zpět na stránku košíku
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(int $id, SessionInterface $session): Response
    {
        // Načtení aktuálního obsahu košíku
        $cart = $session->get('cart', []);

        // Odebrání produktu z košíku
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        // Uložení košíku zpět do relace
        $session->set('cart', $cart);

        // Přesměrování zpět na stránku košíku
        return $this->redirectToRoute('app_cart');
    }
    

    // Volitelná metoda pro vyprázdnění košíku
    #[Route('/cart/clear', name: 'app_cart_clear')]
    public function clear(SessionInterface $session): Response
    {
        // Vyprázdnění košíku
        $session->remove('cart');

        // Přesměrování zpět na stránku košíku
        return $this->redirectToRoute('app_cart');
    }
}
