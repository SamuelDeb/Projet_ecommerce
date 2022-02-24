<?php

namespace App\Controller;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    //entityMAnager : Doctrine : exécuter les requêtes
    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/', name: 'accueil')]
    public function accueilAction(): Response
    {
        $produit = $this->em->getRepository(Produit::class)->findAll();
        
        return $this->render('accueil/accueil.html.twig',[
            'produit'=>$produit
        ]);
        
        
    }   
}