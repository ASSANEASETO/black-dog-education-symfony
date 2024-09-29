<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Mes services')
        ->setEntityLabelInSingular('Un service')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page mes services')
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ->setPaginatorPageSize(10);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id','Identifiant')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextField::new('slug', 'Identifiant text')->onlyOnForms(),
            TextEditorField::new('summury', 'Sommaire')->onlyOnForms(),
            TextEditorField::new('description', 'Description')->onlyOnForms(),
        ];
    }
    
}
