<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Produit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    #[Route('/cart', name: 'cart')]
    public function index(Cart $panier): Response
    {

        //dd($panier->afficher());
        $contenuPanier=[];
        if(!empty($panier->afficher())){
        foreach($panier->afficher() as $id=> $quantite){
            $contenuPanier[] = [
                'produit' => $this->em->getRepository(Produit::class)->find($id),
                'quantite'=> $quantite
            ];
        }
    }
            //dd($contenuPanier);
        return $this->render('cart/cart.html.twig', [
           'panier' => $contenuPanier
        ]);
    }
    
    

    #[Route('/cart/ajouter/{id}', name: 'ajouterPanier')]
    public function ajouterPanier(Cart $panier, $id): Response
    {
        $panier-> ajouter($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/reduire/{id}', name: 'reduirePanier')]
    public function reduirePanier(Cart $panier, $id): Response
    {
        $panier-> diminuer($id);
        
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/supprimer/{id}', name: 'supprimerPanier')]
    public function supprimerPanier(Cart $panier, $id): Response
    {
        $panier-> supprimer($id);
        
        return $this->redirectToRoute('cart');
    }


    #[Route('/cart/vider', name: 'viderPanier')]
    public function viderPanier(Cart $panier): Response
    {
        $panier-> vider();
        return $this->redirectToRoute('cart');
    }

   
}