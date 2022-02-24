<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texte', TextType::class, [
                'label' => 'Recherche',
                'required'=> false,
                'attr' => [
                    'placeholder' => 'Saisir votre recherche',
                    'class'=>'form-control-sm'
                            
                ]
            ])
            
            ->add('Categorie', EntityType::class, [
                'label'=>'Recherche par categorie',
                //si on veut agir sur le label 'label_attr'
                'required'=> false,
                'class'=>Categorie::class,
                'multiple' =>true,
                'expanded' =>true,
                'attr'=>[
                    'class' => 'form-check-input'
                ]
            ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Rechercher',
                    'attr'=>[
                        'class'=>'btn-block btn-info'
                    ]
                ]
            )
            ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method'=> 'GET',
            'csrf_protection'=> false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}