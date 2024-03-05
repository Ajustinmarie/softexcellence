<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class PassModificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class,[
            'label'=>'Votre nom',
            'disabled'=>true,
            'constraints'=> new Length([
                'min'=>2,
                'max'=>30
            ])
        ] )


        ->add('prenom', TextType::class,[
            'label'=>'Votre prenom',
            'disabled'=>true,
            'constraints'=> new Length([
                'min'=>2,
                'max'=>30
            ]),
           
        ] )


        ->add('email', EmailType::class,[
            'label'=>'Votre email',
            'disabled'=>true,
            'constraints'=> new Length([
                'min'=>2,
                'max'=>60
            ])
        ] )
       
       // ->add('roles')

       ->add('old_password', PasswordType::class,[
        'label'=>'Mon mot de passe actuel',
        'mapped'=>false,
        'attr'=>[
            'placeholder' =>'Merci de saisir votre mot de passe actuel'
           ]
      ])


      ->add('new_password', RepeatedType::class,[
        'type'=>PasswordType::class,
        'mapped'=>false,
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
             
            ->add('numero',TextType::class,[
                'label'=>'Numero',
            
                'required' => false,
            ] )


            ->add('adresse',TextType::class,[
                'label'=>'Adresse',
            ] )

            
            ->add('complement_adresse',TextType::class,[
                'label'=>'Complément d\'adresse',
               
            ] )

        ->add('pays', CountryType::class,[
            'label'=>'Pays',
            'constraints'=> new Length([
                'min'=>2,
                'max'=>30
            ]),
        ] )


        ->add('ville',TextType::class,[
            'label'=>'Pays',
            'constraints'=> new Length([
                'min'=>2,
                'max'=>30
            ]),
        ] )


        ->add('submit', SubmitType::class,
        [
            'label' => 'Modifier les informations'
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
