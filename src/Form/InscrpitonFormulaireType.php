<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class InscrpitonFormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Générer une valeur aléatoire cryptée
        $valeurAleatoire = md5(uniqid(rand(), true));

        $builder           

            ->add('nom', TextType::class,[
                'label'=>'Votre nom',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre nom'
                ]
            ])

            ->add('prenom', TextType::class,[
                'label'=>'Votre prenom',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre prenom'
                ]
            ])

            ->add('email', EmailType::class,[
                'label'=>'Votre email',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>60
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre adresse email'
                ]
            ] )           
           // ->add('roles')

            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message'=>'Le mot de passe et la confirmation doiven etre identique',
                'label'=>'Votre mot de passe',
                'required'=>true,
                'first_options' =>[
                    'label'=>'Mot de passe',
                    'attr'=>[
                    'placeholder' =>'Merci de saisir votre mot de pase'
                    ]
                ],
                'second_options'=>[
                'label'=>'Confirmez votre mot de passe',
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre mot de passe'
                   ]
                ]
    
                ])
           
                ->add('numero',TextType::class,[
                    'label'=>'Numero',
                    'required' => false,
                    'attr'=>[
                        'placeholder' =>'Merci de saisir votre numero de téléphone'
                    ]
                ] )


                ->add('adresse',TextType::class,[
                    'label'=>'Adresse',
                    'attr'=>[
                        'placeholder' =>'Merci de saisir votre adresse'
                    ]
                ] )

                
                ->add('complement_adresse',TextType::class,[
                    'label'=>'Complément d\'adresse',
                    'required' => false,
                    'attr'=>[
                        'placeholder' =>'Merci de saisir votre complement d\'adresse'
                    ]
                ] )


                ->add('TokenUser',HiddenType::class,[
                    'data'=> $valeurAleatoire               
                ] )

           
                ->add('pays', CountryType::class,[
                'label'=>'Pays',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre pays'
                ]
            ] )


            ->add('ville',TextType::class,[
                'label'=>'Ville',
                'constraints'=> new Length([
                    'min'=>2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder' =>'Merci de saisir votre ville'
                ]
            ] )


            ->add('submit', SubmitType::class,
            [
                'label' => 'Envoyer'
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
