<?php

namespace App\Controller\Admin;

use App\Entity\Source;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Source::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Les plateformes')
            ->setPageTitle('edit', 'Modifier une plateforme')
            ->setEntityLabelInPlural('Les plateformes')
            ->setEntityLabelInSingular('une plateforme')
            ->setSearchFields(null);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->hideOnIndex();
        yield TextField::new('featText', 'Description')
            ->hideOnIndex();
        yield AssociationField::new('featImg', 'Image')
            ->hideOnIndex();
        yield ColorField::new('color', 'Couleur');
        yield DateField::new('createdAt', 'Création')
            ->hideOnForm();
        yield DateField::new('updatedAt', 'Modification')
            ->hideOnForm();
    }
}
