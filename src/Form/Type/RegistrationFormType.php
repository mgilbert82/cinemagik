<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{

    public function __construct(
        public TranslatorInterface $translator
    ) {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous avez oublié de saisir votre email!',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre email doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 20,
                    ]),
                ],
                'attr' => [
                    'class' => 'my-4 p-2 w-full rounded-lg text-black bg-[#F8FAFC]',
                    'placeholder' => 'Email',
                ],

            ])
            ->add('username', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous avez oublié de saisir votre nom!',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 20,
                    ]),
                ],
                'attr' => [
                    'class' => 'my-4 p-2 w-full rounded-lg text-black bg-[#F8FAFC]',
                    'placeholder' => 'Username',

                ],

            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'my-4 p-2 w-full rounded-lg text-black bg-[#F8FAFC]',
                        'placeholder' => 'Password',
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'my-4 p-2 w-full rounded-lg text-black bg-[#F8FAFC]',
                        'placeholder' => 'Repeat the password',

                    ],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'The password is required!',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 20,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
