<?php

namespace App\Form;

use App\Entity\ContactForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => false,
                'constraints'=> [
                    new NotBlank([
                    'message' => 'Veuillez mettre votre nom'
                    ]),
                    new Length ([
                    'min' => 3,
                    'minMessage' => 'Votre nom doit contenir au moins {{ limit }}',
                    'max' => 200,
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
                        'max' => 200,
                ]),
                ],
            ])
            ->add('number', IntegerType::class,[ 
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
            ->add('subject', TextType::class,[ 
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 0,
                        'minMessage' => 'Your subject should be at least {{ limit }} characters',
                        'max' => 200,
                        'maxMessage' => 'Your subject cannot be longer than {{ limit }} characters'
                ]),
                ],
            ])
            
            ->add('message', TextareaType::class,[ 
           'label' => false

            ])
            ->add('save', SubmitType::class,[
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactForm::class,
        ]);
    }
}
