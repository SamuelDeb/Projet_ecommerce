<?php

namespace App\Controller;

use App\Class\Mailing;
use App\Form\ContactType;
use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsletterController extends AbstractController
{

    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    #[Route('/profil/newsletter', name: 'newsletter')]
   
        
        public function index(Request $request, MailerInterface $mailer)
        {
            $form = $this->createForm(NewsletterType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
    
                //envoi du mail
                
                $emailDest = $form->get('email')->getData();
                $nameDest = $form->get('nom')->getData();
                
               //dd($emailSource);
               $email = new Mailing;
                $idModele= 3691786;
                $email->newsletter(
                    $idModele,
                    $emailDest,
                    $nameDest,
                    "Newsletter",
                    "Bonjour, félicitation votre inscription est valide vous pouvez vous connecter "
                    
                );
               
                $this->addFlash('success', 'Vous avez bien été inscrit à la newsletter');
                return $this->redirectToRoute('newsletter');
            }
            return $this->render('newsletter/newsletter.html.twig', [
                'form' => $form->createView()
            ]);
        }


        
    }