<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Saisir votre nom']
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [new Length(['min'=> 4, 'max'=> 20])],
                'attr' => ['placeholder' => 'Saisir votre prénom']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse E-mail',
                'attr' => ['placeholder' => 'Saisir votre email']
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'years' => range(1900, 2030),
                'format' => 'dd-MM-yyyy',

            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => ['placeholder' => 'Votre numéro de téléphone']
            ])
            // Méthode en créant 2 champs et PasswordTypes
            //->add('password', PasswordType::class,[
            //  'label'=>'Mot de passe',
            //'attr' =>['placeholder'=>'Saisir votre mot de passe']
            //]

            //)

            //->add('password_confirm', PasswordType::class,[
            //    'label'=>'Confirmation mot de passe',
            //   'mapped'=>false, 
            //   'attr' =>['placeholder'=>'Confirmer votre mot de passe']
            // ]
            // )

            //Méthode avec RepeatedType qui va géré les 2 champs 
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe de confirmation ne correspond pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe', 'attr' =>['placeholder'=>'Saisir votre mot de passe']],
                'second_options' => ['label' => 'Confirmer mot de passe', 'attr' =>['placeholder'=>'Confirmer votre mot de passe']],
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'S\'inscrire'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}