<?php

namespace App\Controller\Admin;

use App\Entity\Trouble;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TroubleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trouble::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Les principaux troubles')
        ->setEntityLabelInSingular('Une principale trouble')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page Les principaux troubles')
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
            TextEditorField::new('content', 'Description')->onlyOnForms(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName', 'Image')->setBasePath('/assets/img')->setUploadDir('public/assets/img')->hideOnForm(),
            DateTimeField::new('updated_at', 'Mise à jour')->hideOnForm(),
        ];
    }
    
    
}