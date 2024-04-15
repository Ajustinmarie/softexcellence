<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\Length;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('new_password', RepeatedType::class,[
            'type'=>PasswordType::class,
            'invalid_message'=>'Le mot de passe et la confirmation doiven etre identique',
            'label'=>'Mon nouveau mot de passe',
            'required'=>true,
            'first_options' =>[
                'label'=>'Mon nouveau mot de passe',
                'attr'=>[
                'placeholder' =>'Merci de saisir votre nouveau mot de pase'
                ]
            ],
            'second_options'=>[
            'label'=>'Confirmez votre nouveau mot de passe',
            'attr'=>[
                'placeholder' =>'Merci de confirmer votre nouveau mot de passe'
               ]
            ]
    
            ])
    
    
            ->add('submit', SubmitType::class,
            [
                'label' => 'Mettre à jour mon mot de passe',
                'attr'=>[
                    'class' => 'btn-block btn-info mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
