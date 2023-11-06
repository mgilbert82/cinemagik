<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class FileToAvatarTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        // Transforme la donnée du modèle en une valeur pour la vue (non nécessaire dans ce cas)
        return $value;
    }

    public function reverseTransform($value)
    {
        // Assurez-vous que $value contient le chemin complet du fichier
        $path = $value;

        // Vérifiez si le fichier existe avant de créer une instance de File
        if (file_exists($path)) {
            return new File($path);
        }

        // Si le fichier n'existe pas, retournez null ou générez une exception appropriée
        return null;
    }
}
