<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Vytvoření objektu Contact
        $contact = new Contact();
        $contact->setFirstName('John');
        $contact->setLastName('Doe');
        $contact->setEmail('johndoe@gmail.com');
        $contact->setNumber('123456789');
        $contact->setNote('This is a sample note.');

        // Uložení do databáze (pokud to není potřeba, tento blok můžete vynechat)
        $entityManager->persist($contact);
        $entityManager->flush();

        // Předání dat do šablony
        return $this->render('contact/index.html.twig', [
            'contact' => $contact, // Předání celého objektu
        ]);
    }
}
