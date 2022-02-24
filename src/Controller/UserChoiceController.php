<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Transporteur;
use App\Form\AdresseChoiceType;
use App\Form\TransporteurChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserChoiceController extends AbstractController
{
    
    #[Route('/compte/choisir/adresse', name: 'choisirAdresse')]
    public function choixAdresse(): Response
    {

        $form = $this->createForm(AdresseChoiceType::class, null, [
            'user' => $this->getUser()
        ]);
        return $this->render('user_choice/choisirAdresse.html.twig', [
            'f'=> $form->createView()
            
        ]);
    }

    #[Route('/compte/choisir/transporteur', name: 'choisirTransporteur')]
    public function choixTransporteur(Request $request): Response
    {
        //Récupération des données de livraison choisis
        $adrL = null;
        $adrF = null;
        $formAdresse = $this->createForm(AdresseChoiceType::class, null, [
            'user' => $this->getUser()
        ]);
        $formAdresse->handleRequest($request);
        if($formAdresse->isSubmitted() && $formAdresse->isValid()){
            $adrL = $formAdresse->get('adresseLivraison')->getData();
            $adrF = $formAdresse->get('adresseFacturation')->getData();
        }
        
        $form = $this->createForm(TransporteurChoiceType::class, null);
        
        return $this->render('user_choice/choisirTransporteur.html.twig', [
            'f'=> $form->createView(),
            'adrL' => $adrL,
            'adrF' => $adrF
        ]);
    }
    
}