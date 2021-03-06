<?php

namespace App\Form;

use App\Entity\News;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('is_Subscribe', CheckboxType::class, [
                'label'=> 'Souhaitez-vous vous abonner à la Newsletter ?'  
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'S\'abonner à la newsletter'
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