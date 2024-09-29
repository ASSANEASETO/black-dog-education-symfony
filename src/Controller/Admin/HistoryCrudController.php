<?php

namespace App\Controller\Admin;

use App\Entity\History;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class HistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return History::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Histoire')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page mon histoire')
        
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ->setPaginatorPageSize(10);
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id','Identifiant')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('summury', 'Sommaire')->onlyOnForms(),
            TextEditorField::new('content', 'Description')->onlyOnForms(),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName', 'Image')->setBasePath('/assets/img')->setUploadDir('public/assets/img')->hideOnForm(),
            DateTimeField::new('updated_at', 'Mise à jour')->hideOnForm(),
        ];
    }
    
}



// ->setFormType(CKEditorType::class)