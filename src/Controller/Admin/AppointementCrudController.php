<?php

namespace App\Controller\Admin;

use App\Entity\Appointement;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class AppointementCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return Appointement::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Demande de rendez-vous')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page demande de rendez-vous')
        ->setPaginatorPageSize(20)

        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id','Identifiant')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('prestations', 'Prestations')->hideOnIndex(),
            TextField::new('breed', 'Races')->hideOnIndex(),
            DateField::new('date', 'Date')->hideOnForm(),
            TimeField::new('time','Heure'),
            NumberField::new('dogNumber', 'Nombre de chien(s)')->hideOnIndex(),
            NumberField::new('puppyNumber', 'Nombre de chiot(s)')->hideOnIndex(),
            NumberField::new('phoneNumber', 'Numéro de téléphone'),
            NumberField::new('age', 'Age')->hideOnIndex(),
            EmailField::new('email', 'Adresse e-mail'),
        ];
    }
    
}
