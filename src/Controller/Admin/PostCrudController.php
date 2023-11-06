<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Range;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Les articles')
            ->setPageTitle('edit', 'Modifier l\'article')
            ->setEntityLabelInPlural('Les articles')
            ->setEntityLabelInSingular('l\'article')
            ->setSearchFields(null);
    }


    public function configureFields(string $pageName): iterable
    {
        yield DateField::new('createdAt', 'Création')
            ->hideOnForm();
        yield DateField::new('updatedAt', 'Modification')
            ->hideOnForm()
            ->hideOnIndex();
        yield DateField::new('releaseDate', 'Date de sortie')
            ->hideOnIndex();
        yield IntegerField::new('rate', 'Note')
            ->setFormTypeOptions([
                'constraints' => [
                    new Range(['min' => 1, 'max' => 10])
                ]
            ]);
        yield TextField::new('title', 'Titre');
        yield SlugField::new('slug')
            ->setTargetFieldName('title')
            ->hideOnIndex();

        yield TextField::new('featText', 'Texte mise en avant')
            ->hideOnIndex();
        yield TextField::new('trailerUrl', 'Lien bande annonce')
            ->hideOnIndex();
        yield ChoiceField::new('type')
            ->setChoices([
                'FILM' => 'MOVIE',
                'SERIE' => 'TVSHOW'
            ])
            ->renderAsBadges([
                'MOVIE' => 'primary',
                'TVSHOW' => 'success'
            ]);
        yield AssociationField::new('featImg', 'Affiche/image')
            ->hideOnIndex();
        yield AssociationField::new('category', 'Genres')
            ->hideOnIndex();
        yield AssociationField::new('director', 'Réalisateur');
        yield AssociationField::new('actors', 'Les acteurs')
            ->hideOnIndex();
        yield AssociationField::new('source', 'Plateforme');
        yield TextEditorField::new('content')
            ->setLabel('Synopsis')
            ->hideOnIndex();
    }
}
