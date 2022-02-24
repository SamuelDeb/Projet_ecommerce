<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Transporteur;
use App\Entity\CommandeLigne;
use App\Form\TransporteurChoiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecapCommandeController extends AbstractController
{
    private $em;
        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }
    #[Route('/recap/commande/{adrL}/{adrF}', name: 'recap_commande')]
    public function index($adrL, $adrF, Request $request, Cart $panier): Response
    {
        
        $transport =  null;
        $reference = null;
        $formTransport = $this->createForm(TransporteurChoiceType::class, null// , [
        //     'user'->getUser()
        // ]
    );
        $formTransport->handleRequest($request);
        if($formTransport->isSubmitted() && $formTransport->isValid()){
            $transport = $formTransport->get('transporteur')->getData();
            // Préparation de l'objet Commande
            
            $date = new \DateTimeImmutable();
            $reference = $date->format('Ymd').'-'.uniqid();
            $currentUser = $this->getUser();
            $tSociete = $transport->getNom();
            $tPrix = $transport->getPrix();
            $isFinalized = 0;
            // Remplissage de l'objet Commande
            $cmd = new Commande();
            $cmd->setUser($currentUser);
            $cmd->setCreatedAt($date);
            $cmd->setReference($reference);
            $cmd->setAdrLivraison($adrL);
            $cmd->setAdrFacturation($adrF);
            $cmd->setTsociete($tSociete);
            $cmd->setTprix($tPrix);
            $cmd->setIsFinalized($isFinalized);
            $this->em->persist($cmd);
            //Préparation de l'objet CommandeLigne
            foreach ($panier->afficherTout() as $produit) {
                $cmdLigne = new CommandeLigne();
                $cmdLigne->setCommande($cmd);
                $cmdLigne->setProductName($produit['produit']->getNom());
                $cmdLigne->setProductQuantite($produit['quantite']);
                $cmdLigne->setProductPrice($produit['produit']->getPrix());
                $cmdLigne->setTotal(($produit['produit']->getPrix())*($produit['quantite']));
                $this->em->persist($cmdLigne);
            }
            $this->em->flush();
        }
        
        return $this->render('recap_commande/recap.html.twig', [
            'transport' =>$transport,
            'panier'=> $panier->afficherTout(),
            'adrL' => $adrL,
            'adrF' => $adrF,
            'reference'=> $reference
        ]);
    }
    #[Route('/compte/commande', name: 'commande')]
    
    public function commande(): Response
    {
        return $this->render('compte/commande.html.twig');
            
    }
    #[Route('/compte/commandes/{reference}', name: 'detailCommande')]
    public function details($reference): Response
    {
        $order = $this->em->getRepository(Commande::class)->findOneByReference($reference);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('compte_commande');
        }
        return $this->render('compte/detailCommande.html.twig', [
            'order' => $order
        ]);
    }
}