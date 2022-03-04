<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\User;
use App\Form\NewsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    private $em;//em=entitymanager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em =$em;
    }
    
    #[Route('/profil/news', name: 'news')]
    public function inscription(Request $request, MailerInterface $mailer)
    {   
        $news = new News(); 
       $user = $this->em->getRepository(User::class)->findOneBy(['id'=>$this->getUser()->getId()]);
       $subscribe = $this->getUser()->getIsSubscribe();
        $form = $this->createForm(NewsType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            
             $user->setIsSubscribe(true);
             $news->setUser($user);
             $this->em->persist($user);
             $this->em->persist($news);
             $this->em->flush();
           
            $this->addFlash('success', 'Vous avez bien été inscrit à la newsletter');
            return $this->redirectToRoute('news');
        }
        return $this->render('news/news.html.twig', [
            'form' => $form->createView()
        ]);
    }


    

    
}