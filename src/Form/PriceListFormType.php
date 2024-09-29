<?php

namespace App\Form;

use App\Entity\PriceList;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PriceListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
        ->add('title', TextType::class,[
            'required' => false,
        ])
        ->add('price', IntegerType::class,[
            'required' => false,
        ])
        ->add('summury', TextareaType::class, [
            'required' => false,
        ])
        ->add('description', TextareaType::class, [
            'required' => false,
        ])
        ->add('imageFile', DropzoneType::class,[
            'required' => false,
        ]);
            
        $builder
        ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
            /** @var PriceList $priceList */
            $priceList = $event->getData();
            if (null == $priceList->getSlug() && null !== $priceList->getTitle()) {
                $slugger = new AsciiSlugger();
                $priceList->setSlug($slugger->slug($priceList->getTitle())->lower());
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceList::class,
            'sanitize_html' => true,
            // use the "sanitizer" option to use a custom sanitizer (see below)
            //'sanitizer' => 'app.post_sanitizer'
        ]);
    }
}
