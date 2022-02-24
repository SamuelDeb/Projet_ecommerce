<?php

namespace App\Form;

use App\Entity\Transporteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TransporteurChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('transporteur', EntityType::class, [
            'label'=>'Veuillez choisir le mode de livraison : ',
            'required' =>true,
            'class'=> Transporteur::class,
            'multiple' => false,
            'expanded' => true,
        ])
        
        ->add(
            'submit',
            SubmitType::class,
            [
                'label' => 'Récapitulatif de ma commande'
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Transporteur::class,
        ]);
    }
}