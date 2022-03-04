<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\User;
use App\Form\UnsuscribeNewsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UnsuscribeNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('is_Subscribe', CheckboxType::class, [
                'label'=> 'Souhaitez-vous vous désabonner de la Newsletter ?'  
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Se désabonner'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => News::class,
        ]);
    }
}