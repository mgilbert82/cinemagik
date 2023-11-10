<?php

namespace App\Controller\Admin;

use App\Entity\Actor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actor::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Les acteurs')
            ->setPageTitle('edit', 'Modifier un acteur')
            ->setEntityLabelInPlural('Les acteurs')
            ->setEntityLabelInSingular('un acteur');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->hideOnIndex();
        yield DateField::new('dateOfBirth', 'Date de naissance');
        yield AssociationField::new('featImg', 'Photo')
            ->hideOnIndex();
        yield TextareaField::new('featText', 'Biographie')
            ->hideOnIndex();
        yield DateField::new('createdAt', 'Création')
            ->hideOnForm();
        yield DateField::new('updatedAt', 'Modification')
            ->hideOnForm();
    }
}
