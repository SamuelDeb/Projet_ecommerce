<?php

namespace App\Controller;

use App\Entity\User;
use App\Class\Mailing;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class InscriptionController extends AbstractController
{
    //entityMAnager : Doctrine : exécuter les requêtes
    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user= new User();
        $form = $this->createForm(InscriptionType::class, $user);

        //écoute de la requête du submit
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //récupérer les données du formulaire
            $user = $form->getData();
           //Vérifier si email existe ou non
           $userexiste = $this->em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
           if(!$userexiste){
            //Crypter le mot de passe 
            $pwdHash = $passwordHasher->hashPassword($user,$user->getPassword());
            //Injection du password hacher dans la l'user
            $user->setPassword($pwdHash);
            //figer les données à envoyer vers la BDD
            $this->em->persist($user);
            //Sauvegarde dans la BDD 
            $this->em->flush();
            //Envoi de l'email de confirmation
            $email = new Mailing;
            $idModele= 3640514;
            $email->envoyer(
                $idModele,
                $user->getEmail(),
                $user->getNom(),
                "Inscription réussie",
                "Bonjour, félicitation votre inscription est valide vous pouvez vous connecter "
            );
            $this->addFlash('success', 'Insciption réussi, vous allez recevoir un email de confirmation');
        }
        else{
            $this->addFlash('erreur', 'Erreur d\'inscription, l\'email existe déjà');
        }
        }
        
        return $this->render('inscription/inscription.html.twig',[
            'f' => $form->createView()
        ] );
    }
}