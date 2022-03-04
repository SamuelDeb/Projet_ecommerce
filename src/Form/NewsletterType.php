<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',TextType::class, [
        ])
        ->add('email',EmailType::class, [
        ])
        ->add('news', ChoiceType::class, [
            'label'=>'Souhaitez-vous vous abonner à la newsletter ?',
            'choices'=>[
                'oui'=>'oui',
                'non'=>'non'  
            ],
            'multiple'=>false,
            'expanded'=>true,
        ])
        ->add(
            'submit',
            SubmitType::class,
            [
                'label' => 'S\'inscrire à la newsletter'
            ]
        );
        
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}