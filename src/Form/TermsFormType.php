<?php

namespace App\Form;

use App\Entity\Terms;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TermsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class,[
            'required' => false,
        ])
        ->add('summury', TextareaType::class, [
            'required' => false,
        ])
        ->add('content', TextareaType::class, [
            'required' => false,
        ])
        ->add('imageFile', DropzoneType::class,[
            'required' => false,
        ]);
            
        $builder
        ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
            /** @var Terms $terms */
            $terms = $event->getData();
            if (null == $terms->getSlug() && null !== $terms->getTitle()) {
                $slugger = new AsciiSlugger();
                $terms->setSlug($slugger->slug($terms->getTitle())->lower());
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terms::class,
        ]);
    }
}
