<?php

namespace App\Controller\Admin;

use App\Entity\PriceList;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PriceListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PriceList::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Mes tarifs')
        ->setEntityLabelInSingular('Un tarif')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page mes tarifs')
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
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('imageName', 'Image')->setBasePath('/assets/img')->setUploadDir('public/assets/img')->hideOnForm(),
            DateTimeField::new('updated_at', 'Mise à jour')->hideOnForm(),
        ];
    }
}
