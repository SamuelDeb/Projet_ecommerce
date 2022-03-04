<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UnsuscribeNewsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UnsuscribeNewsController extends AbstractController
{ 
    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }

    
    #[Route('/unsuscribe/news', name: 'unsuscribe_news')]
   
    public function inscription(Request $request, MailerInterface $mailer)
    {   
       $user = $this->em->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
      
        $form = $this->createForm(UnsuscribeNewsType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
             $user->setIsSubscribe(false);
             $this->em->persist($user);
             $this->em->flush();
              //dd($user);
           
            $this->addFlash('success', 'Vous avez bien été désinscrit de la newsletter');
            return $this->redirectToRoute('news');
        }
        return $this->render('news/news.html.twig', [
            'form' => $form->createView()
        ]);
    }
}