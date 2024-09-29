<?php

namespace App\Form;

use App\Entity\History;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class HistoryFormType extends AbstractType
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
            /** @var History $history */
            $history = $event->getData();
            if (null == $history->getSlug() && null !== $history->getTitle()) {
                $slugger = new AsciiSlugger();
                $history->setSlug($slugger->slug($history->getTitle())->lower());
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => History::class,
        ]);
    }
}
