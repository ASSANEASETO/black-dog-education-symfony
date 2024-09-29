<?php

namespace App\Controller\Admin;

use App\Entity\ContactForm;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContactFormCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return ContactForm::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Demande de contact')
        ->setEntityLabelInSingular('Demande de contact')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page demande de contact')
        ->setPaginatorPageSize(20)

        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');

       
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id','Identifiant')->hideOnForm(),
            TextField::new('name', 'Nom'),
            NumberField::new('phoneNumber', 'Numéro de téléphone'),
            EmailField::new('email', 'Adresse e-mail'),
            TextField::new('subject', 'Object'),
            TextEditorField::new('message', 'Messages'),
        ];
    }
    
}
