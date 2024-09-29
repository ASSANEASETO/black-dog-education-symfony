<?php

namespace App\Form;

use App\Entity\Appointement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AppointementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                    'message' => 'Veuillez renseigner ce champs'
                    ]),
                    new Length ([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit contenir au moins {{ limit }}',
                        'max' => 20,
                        ]),
                ],
            ])
            ->add('prestations',  ChoiceType::class,[
                'choices' => [
                        'Évaluation à domicile 35€' => 1,
                        'Cours particulier. 45€' => 2,
                        'Pack Chiot. 300€' => 3,
                        'Pack 3 séances individuelles. 115€' => 4,
                        'Pack 5 séances individuelles. 200€' => 5,
                        ],
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez choisir une prestation svp'
                    ]),
                ],
            ])
            ->add('breed', TextType::class,[ 
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez renseigner la race de votre chien svp'
                    ]),
                    new Length ([
                        'min' => 3,
                        'minMessage' => 'Votre numéro doit contenir au moins {{ limit }}',
                        'max' => 15
                ]),
                ],
            ])
            ->add('dogNumber',  ChoiceType::class,[
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez choisir un nombre svp'
                    ]),
                ],
            ])
            ->add('puppyNumber',  ChoiceType::class,[
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Veuillez choisir un nombre svp'
                    ]),
                ],
            ])
            ->add('phoneNumber', IntegerType::class,[ 
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Votre numéro de téléphone svp'
                    ]),
                    new Length ([
                        'min' => 8,
                        'minMessage' => 'Votre numéro doit contenir au moins {{ limit }}',
                        'max' => 15
                ]),
                new Regex([
                    'pattern' => '/^\d+$/',
                    'message' => 'Votre numéro de téléphone ne doit contenir que des chiffres',
                ]),
                ],
            ])
            ->add('age', IntegerType::class,[ 
                'label' => false,
                'required' => false,
                'constraints'=> [
                    new Length ([
                        'min' => 0,
                        'minMessage' => 'Votre numéro doit contenir au moins {{ limit }}',
                        'max' => 2
                ]),
                new Regex([
                    'pattern' => '/^\d+$/',
                    'message' => 'Votre numéro de téléphone ne doit contenir que des chiffres',
                ]),
                ],
            ])
            ->add('email', EmailType::class,[
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                        'message' => 'Entrez votre email svp'
                    ]),
                    new Length ([
                        'min' => 3,
                        'minMessage' => 'Votre email doit contenir au moins {{ limit }}',
                        'max' => 50,
                ]),
                ],
            ])
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('time', null, [
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class,[
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointement::class,
        ]);
    }
}
