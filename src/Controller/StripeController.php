<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Produit;
use App\Entity\Commande;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index($reference): Response
    {
        
        $ref = str_replace('%20','',$reference);
        $sessionProducts = [];
        $YOUR_DOMAIN = 'http://localhost:8000';
        $commande = $this->em
        ->getRepository(Commande::class)
        ->findOneBy(['reference' => $ref]);
        //dd($commande);
           //Remplir le sessionProducts vie les lignes de commandes
           foreach($commande->getCommandeLignes()->getValues() as $product){
               $prod = $this->em->getRepository(Produit::class)->findOneBy(['nom'=>$product->getProductName()]);
              // dd($prod);
            $sessionProducts[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getProductPrice() * 100,
                    'product_data' => [
                        'name' => $product->getProductName(),
                        'images' => ["assets/images/produits/".$prod->getImage()]
                    ]
                ],
                'quantity' => $product->getProductQuantite()
            ];
        }

           //Ajouter les frais de livraison
           $sessionProducts[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $commande->getTprix() * 100,
                'product_data' => [
                    'name' => $commande->getTsociete(),
                    'images' => [$YOUR_DOMAIN]
                ]
            ],
            'quantity' => 1
        ];
          // This is your test secret API key.
          Stripe::setApiKey('sk_test_51KT0sHFoeBzcLSQgFfipfqXzdJLEIXW0G5hp86IxwkAl2jB00YOhsmDOYIa2EVjQIDXuWUOfAG2SWgGwfDDpbBOA00GyDxjkxI');

        // Création de la session checkout
        $checkout_session = Session::create([
            'customer_email' => $this-> getUser()->getEmail(),
            'payment_method_types' => ['card'], 
            'line_items' => [
              $sessionProducts
            ],
            'mode' => 'payment',
              'success_url' => $YOUR_DOMAIN . '/commande/success/{CHECKOUT_SESSION_ID}',
              'cancel_url' => $YOUR_DOMAIN . '/commande/cancel/cancel.html.twig',
          ]);

          $sessionId = $checkout_session->id;
          
          $commande->setStripeId($sessionId);
          $this->em->flush();
          $response = new JsonResponse(['id' => $sessionId]);
          return $response;
       
    }
}