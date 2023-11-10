<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Les médias')
            ->setPageTitle('edit', 'Modifier une image')
            ->setEntityLabelInPlural('Les images')
            ->setEntityLabelInSingular('une image');
    }

    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
        $uploadDir = $this->getParameter('uploads_directory');

        yield TextField::new('name', 'Nom');
        yield SlugField::new('slug')
            ->setTargetFieldName('name')
            ->hideOnIndex();
        $mediaField = ImageField::new('filename', 'Média')
            ->setBasePath($uploadDir)
            ->setUploadDir($mediaDir)
            ->setUploadedFileNamePattern('[uuid].[extension]');

        if (Crud::PAGE_EDIT === $pageName) {
            $mediaField->setRequired(false);
        }

        yield $mediaField;
    }
}
