<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class,[
            'required' => false,
        ])
        ->add('slug', TextType::class,[
            'required' => false,
        ])
        ->add('summury', TextareaType::class, [
            'required' => false,
        ])
        ->add('description', TextareaType::class, [
            'required' => false,
        ]);

        $builder
        ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
           
            $service = $event->getData();
            if (null == $service->getSlug() && null !== $service->getTitle()) {
                $slugger = new AsciiSlugger();
                $service->setSlug($slugger->slug($service->getTitle())->lower());
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
