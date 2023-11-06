<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Form\DataTransformer\FileToAvatarTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAvatarType extends AbstractType
{
    private $fileToAvatarTransformer;

    public function __construct(FileToAvatarTransformer $fileToAvatarTransformer)
    {
        $this->fileToAvatarTransformer = $fileToAvatarTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'avatar',
                FileType::class,
                [
                    'label' => 'Choisir son avatar',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'my-4 p-2 w-full rounded-lg text-black bg-[#F8FAFC]',
                    ],
                ]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'bg-yellow-400 text-black text-center p-2 rounded-lg',
                ],
            ]);

        $builder->get('avatar')->addModelTransformer($this->fileToAvatarTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
