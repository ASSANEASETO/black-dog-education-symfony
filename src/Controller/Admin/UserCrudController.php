<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Administrateurs')
        ->setEntityLabelInSingular('Administrateur')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de mes accès')
        ->setPaginatorPageSize(10);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Informations de base'),
            IdField::new('id', 'Identifiant')->hideOnForm(),
            EmailField::new('email', 'Adresse e-mail'),
            FormField::addPanel('Droits d\'accès'),
            ChoiceField::new('roles','Rôles')
            ->setChoices([
                'Super admin' => 'ROLE_SUPER_ADMIN',
                'Administrateur' => 'ROLE_ADMIN',
            ])
            ->allowMultipleChoices()
            ->renderAsBadges(),
            TextField::new('plainPassword', 'Mot de passe')->onlyOnForms()->setLabel('Password'),
            BooleanField::new('isVerified', 'Vérification')->hideOnForm()
        ];
    }
    
}
