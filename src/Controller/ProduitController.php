<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Produit;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    //entityMAnager : Doctrine : exécuter les requêtes
    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    #[Route('/produit', name: 'produit')]
    public function index(Request $request ): Response
    {

        //Fonctionnement des SessionInterface
        //est dépréciée remplacée par RequestStack équivalent de LocalStorage avec les méthodes de SessionInterface
        /*
        public function index(Request $request , RequestStack $rs): Response
        {
        Tester RequestStack
        dans une session les données sont stockées sous forme de couple : clé => valeur
        panier => []
        user => []
        
        //initialisatin d'un tableau de panier 
            $rs->getSession()->set('panier',[
                [
                'name'=>'Bleach tome1',
                'prix'=> 6,90
                'quantite'=> 10
                ],
                [
                    'name'=>'Naruto tome 1 à 3',
                    'prix'=> 9
                ]
                
            ]); 
            
            dd($rs->getSession()->get('panier'));
            //Pour vider la session 
            $rs->getSession()->remove('panier'); 
           
            }
         */   
        
        //Récupération de la liste des articles
        $produit = $this->em->getRepository(Produit::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $search = $form->getData();
            $produit = $this->em->getRepository(Produit::class)->findBySearch($search);
        }

        
        return $this->render('produit/produit.html.twig', [
           'produit'=>$produit,
           'f' => $form->createView()
        ]);
    }

    #[Route('/detailsProduit/{id}', name: 'detailsProduit')]
    public function detailproduit($id): Response
    {
        //Récupération de la liste des articles
        $produit = $this->em->getRepository(Produit::class)->find($id);
        return $this->render('produit/detailsProduit.html.twig', [
           'produit'=>$produit
        ]);
    }

    
}