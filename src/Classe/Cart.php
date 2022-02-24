<?php

namespace App\Classe;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart 
{
    //initialiser une session
   
    private $rs;
    public function __construct(RequestStack $rs, EntityManagerInterface $em)
    {
        $this->rs = $rs;
        $this->em = $em;
     
    }

    //Créer une session
    public function ajouter($id)
    {
        //créer une sauvegarde
        $panier = $this->rs->getSession()->get('panier',[]);
        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }else{
            $panier[$id]=1;
        }
        
        $this->rs->getSession()->set('panier', $panier);


        //$this->rs->set('panier', [
         //   [
           //     'id'=>$id,
            //    'quantite'=> 1
           // ]
        //]);
    }

    public function diminuer($id)
    {
        //créer une sauvegarde
        $panier = $this->rs->getSession()->get('panier',[]);
        if($panier[$id]>1)
        {
            $panier[$id]--;
        }else{
            unset($panier[$id]);
        }
        
        $this->rs->getSession()->set('panier', $panier);
    }

    public function supprimer($id)
    {
        //créer une sauvegarde
        $panier = $this->rs->getSession()->get('panier',[]);
       
            unset($panier[$id]);
 
        $this->rs->set('panier', $panier);
    }
    
    public function afficher()
    {
        return $this->rs->getSession()->get('panier');
    }

    public function afficherTout()
    {
        $contenuPanier=[];
        if($this->afficher()){
        foreach($this->afficher() as $id => $quantite){
            $obj = $this->em->getRepository(Produit::class)->find($id);
            if(!$obj){
                $this->supprimer($id);
                continue;
            }
            $contenuPanier[] = [
                'produit' => $obj,
                'quantite'=> $quantite
            ];
        }
    }
    return $contenuPanier;
    }
    
    public function vider()
    {
        return $this->rs->getSession()->remove('panier');
    }

    //afficher le nombre d'article
    public function nbArticle()
    {
        $nb=0;
        if($this->afficher()){
            foreach ($this->afficher() as $id => $qty) {
                $nb += $qty;
                
            }
        }
        return $nb;
    }
    
}
    