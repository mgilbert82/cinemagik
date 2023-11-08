<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Les genres')
            ->setPageTitle('edit', 'Modifier un genre')
            ->setEntityLabelInPlural('Les genres')
            ->setEntityLabelInSingular('un genre')
            ->setSearchFields(null);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->hideOnIndex();
        yield AssociationField::new('media', 'Image')
            ->hideOnIndex();
        yield TextareaField::new('featText', 'Définition')
            ->hideOnIndex();
        yield ColorField::new('color', 'Couleur')
            ->hideOnIndex();
        yield DateField::new('createdAt', 'Création')
            ->hideOnForm();
        yield DateField::new('updatedAt', 'Modification')
            ->hideOnForm();
    }
}
