<?php

namespace App\Controller;

use App\Class\Mailing;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //envoi du mail de contact
            
            $emailSource = $form->get('email')->getData();
            $nameSource = $form->get('nom')->getData();
            $emailContent = $form->get('message')->getData();
            
           //dd($emailSource);
           $email = new Mailing;
            $idModele= 3646958;
            $email->contacter(
                $idModele,
                $emailSource,
                $nameSource,
                "Contact",
                $emailContent
            );
           
            $this->addFlash('success', 'Vore message a été envoyé');
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}