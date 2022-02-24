<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdresseChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
        ->add('adresseLivraison', EntityType::class, [
            'label'=>'Choisir votre adresse de livraison : ',
            'required' =>true,
            'class'=> Adresse::class,
            'choices'=> $user->getAdresses(),
            'multiple' => false,
            'expanded' => true,
        ])

        ->add('adresseFacturation', EntityType::class, [
            'label'=>'Choisir votre adresse de facturation : ',
            'required' =>true,
            'class'=> Adresse::class,
            'choices'=> $user->getAdresses(),
            'multiple' => false,
            'expanded' => true,
        ])
        
        ->add(
            'submit',
            SubmitType::class,
            [
                'label' => 'Valider l\'adresse'
            ]
        );
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array(),
        ]);
    }
}