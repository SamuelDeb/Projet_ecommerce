<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdresseController extends AbstractController
{
    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    
    #[Route('/compte/adresse', name: 'adresse')]
    
    public function index(): Response
    {
        return $this->render('adresse/adresse.html.twig');
            
    }
    #[Route('/compte/adresse/ajouter', name: 'ajouterAdresse')]
    
    
    public function ajouterAdresse(Request $request): Response
    {
      
        $addr= new Adresse();
        $form = $this->createForm(AdresseType::class, $addr);

        //écoute de la requête du submit
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //récupérer les données du formulaire
            $addr->setUser($this->getUser());//recup l'user
            $addr = $form->getData();
        //figer les données à envoyer vers la BDD
            $this->em->persist($addr);
            //Sauvegarde dans la BDD 
            $this->em->flush();
            $this->addFlash('success', 'L\'adresse à  été ajouter');
            return $this->redirectToRoute('adresse');
       }    
        
        return $this->render('adresse/ajouterAdresse.html.twig', [
            'f' => $form->createView()
        ]);
    
}
    #[Route('/compte/adresse/supprimer/{id}', name: 'supprimerAdresse')]
    
    
    public function supprimerAdresse($id): Response
    {
        
        $addr= $this->em->getRepository(Adresse::class)->find($id); 
        if($addr && $this->getUser() == $addr->getUser()){ //si addresse existe et utilisateur connecter et bien l'utilisateur de cette adresse
            $this->em->remove($addr);
            $this->em->flush();

        }
        $this->addFlash('success', 'L\'adresse à  été supprimer');
        return $this->redirectToRoute('adresse');
}
#[Route('/compte/adresse/modifier/{id}', name: 'modifierAdresse')]
    
    
    public function modifierAdresse($id, Request $request): Response
    {
        
        $addr= $this->em->getRepository(Adresse::class)->find($id); 
        if($addr && $this->getUser() == $addr->getUser()){ //si addresse existe et utilisateur connecter et bien l'utilisateur de cette adresse
            $form = $this->createForm(AdresseType::class, $addr);
            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid()){
                $this->em->flush();
                
            $this->addFlash('success', 'L\'adresse à  été modifier');
            return $this->redirectToRoute('adresse');
            }
           
        }
        return $this->render('adresse/ajouterAdresse.html.twig', [
            'f' => $form->createView()
        ]);
        
}


}