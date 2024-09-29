<?php

namespace App\Controller\Admin;

use App\Entity\Invitation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Controller\Admin\Trait\CreateReadDeleteTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InvitationCrudController extends AbstractCrudController
{
    use CreateReadDeleteTrait;
    public static function getEntityFqcn(): string
    {
        return Invitation::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInSingular('Invitation')
        ->setEntityLabelInPlural('Invitations')
        
        ->setPageTitle('index', 'Black Dog Education - Administration de ma page des Invitations')

        ->setPaginatorPageSize(10);
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Informations de base'),
            EmailField::new('email', 'Adresse e-mail'),
            TextField::new('uuid', 'Identifiant unique')->hideWhenCreating(),
            AssociationField::new('reader', 'Lecteur')->hideWhenCreating(),
            FormField::addPanel('Droits d\'accès'),
            ChoiceField::new('roles','Rôles')
            ->setChoices([
                'Super admin' => 'ROLE_SUPER_ADMIN',
                'Administrateur' => 'ROLE_ADMIN',
            ])
            ->allowMultipleChoices()
            ->renderAsBadges()
            ->setRequired(true)
            ->setEmptyData(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']), // Set default role
        ];
    }
}
