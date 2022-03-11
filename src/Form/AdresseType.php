<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Form\AdresseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('libele', TextType::class,[
            'label'=>'Libelé',
            'attr'=>['placeholder'=>'Libélé']
            
        ])
        
        
            ->add('nom', TextType::class,[
                'label'=>'Nom',
                'attr'=>['placeholder'=>'Saisir votre nom ']
                
            ])

            ->add('prenom', TextType::class,[
                'label'=>'Prénom',
                'attr'=>['placeholder'=>'Saisir votre prenom']
               
                ])
                ->add('societe', TextType::class,[
                    'label'=>'société',
                    'attr'=>['placeholder'=>'Saisir nom de la société ']
                    
                ])
               
            ->add('nomAdresse', TextType::class,[
                    'label'=>'Nom rue',
                    'attr'=>['placeholder'=>'Saisir le nom la rue']
                    
                ])
                
            ->add('numero', TextType::class,[
                'label'=>'Numéro',
                'attr'=>['placeholder'=>'Saisir le numéro de la rue']
            ])
            ->add('rue', ChoiceType::class, [
                'choices'=>[
                    'rue'=>'Rue',
                    'avenue'=>'avenue',
                    'boulevard'=>'boulevard',
                    
                ],
                'multiple'=>true,
                'expanded'=>true,
            ])
            ->add('codePostale', TextType::class,[
                'label'=>'Code Postale',
                'attr'=>['placeholder'=>'Saisir le code postale']
            ])
            ->add('ville', TextType::class,[
                'label'=>'Ville',
                'attr'=>['placeholder'=>'Saisir votre ville']
            ])
            ->add('pays', CountryType::class,[
                'label'=>'Pays',
                'attr'=>['placeholder'=>'Saisir le pays']
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Enregistrer l\'adresse'
                ]
            );
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}