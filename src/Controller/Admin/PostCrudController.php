<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
        
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Mes publications')
        ->setEntityLabelInSingular('Une publication')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page blog')
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ->setPaginatorPageSize(10);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id','Identifiant')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('summary', 'Sommaire')->onlyOnForms(),
            TextEditorField::new('content', 'Description')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Date de création'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName', 'Image')->setBasePath('/assets/img')->setUploadDir('public/assets/img')->hideOnForm(),
            DateTimeField::new('updated_at', 'Mise à jour')->hideOnForm(),
        ];
    }
    
}
