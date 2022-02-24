<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\User;
use App\Class\Mailing;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeReturnController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    
    #[Route('/commande/success/{stripeId}', name: 'stripe_return')]
    public function index($stripeId, Cart $panier): Response
    {
        $commande = $this->em->getRepository(Commande::class)->findOneBy(['stripeId' => $stripeId]);
        $user= $this->em->getRepository(User::class)->findOneBy(['email'=> $user->getEmail()]);
        if(!$commande){
            return $this->redirectToRoute('accueil');
        }
       // Modifier le isFinalized
       $commande->setIsFinalized(1);
       $this->em->flush();
       //Envoi du mail de confirmation de commande
       $emailConfCommande = new Mailing;
       $emailConfCommande->envoyer(
            
           $user->getEmail(),
           $user->getNom(),
           "Commande validée",
           "Bonjour, Merci pour votre commande ",
           null
       );
       $this->addFlash('success', 'Insciption réussi, vous allez recevoir un email de confirmation');
   
   
       //Vider le panier
       $panier->vider();
       $this->addFlash('success', 'Le payement de votre commande a bien été accepter, Merci pour votre commande. ');
     return $this->render('stripe_return/success.html.twig',[
         'commande'=>$commande
     ]);
     
    }

    #[Route('/commande/cancel/{stripeId}', name: 'stripereturn')]
    public function cancel($stripeId, Cart $panier): Response
    {
        $commande = $this->em->getRepository(Commande::class)->findOneBy(['stripeId' => $stripeId]);

      
        $this->addFlash('success', 'Le payment de votre commande a été refuser');
     return $this->render('stripe_return/cancel.html.twig',[
         'commande'=>$commande
     ]);
     
     }
    
}