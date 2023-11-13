<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\EditAvatarType;
use App\Form\Type\EditPasswordType;
use App\Form\Type\EditProfileType;
use App\Form\Type\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    public function __construct(
        public EntityManagerInterface $entityManager,
        public UserPasswordHasherInterface $passwordHasher,
    ) {
    }
    #[Route('/creer-son-compte', name: 'app_register')]
    public function register(Request $request): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'avatar
            $avatarFile = $form->get('avatar')->getData();

            //Dossier d'upload
            $upload_directory = $this->getParameter('avatars_directory');

            //Renommer le fichier
            if ($avatarFile) {
                $newFilename = md5(uniqid()) . '.' . $avatarFile->guessExtension();

                //Déplacez le fichier vers le repertoire
                try {
                    $avatarFile->move(
                        $upload_directory,
                        $newFilename
                    );

                    //Enregistrer le nom du fichier de l'avatar dans la base de données
                    $user->setAvatar($newFilename);
                } catch (FileException $e) {
                    $this->addFlash(
                        'success',
                        $e->getMessage()
                    );
                }

                // Enregistrez le nom du fichier de l'avatar dans la base de données
                $user->setAvatar($newFilename);
            }


            // encode the plain password
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route(path: '/se-connecter', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/se-deconnecter', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/mon-compte', name: 'app_profile')]
    public function index()
    {
        return $this->render('user/userProfile.html.twig', []);
    }

    #[Route('/mon-compte/modifier', name: 'app_edit_profile')]
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/editProfile.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/mon-compte/modifier/avatar', name: 'app_edit_avatar')]
    public function editAvatar(Request $request)
    {
        $user = $this->entityManager->find(User::class, $this->getUser());
        $form = $this->createForm(EditAvatarType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'avatar
            $avatarFile = $form->get('avatar')->getData();

            //Dossier d'upload
            $upload_directory = $this->getParameter('avatars_directory');

            //Renommer le fichier
            if ($avatarFile) {
                $newFilename = md5(uniqid()) . '.' . $avatarFile->guessExtension();

                //Déplacez le fichier vers le repertoire
                try {
                    $avatarFile->move(
                        $upload_directory,
                        $newFilename
                    );

                    //Enregistrer le nom du fichier de l'avatar dans la base de données
                    $user->setAvatar($newFilename);

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();

                    $this->addFlash('success', 'Avatar mis à jour');

                    return $this->redirectToRoute('app_profile');
                } catch (FileException $e) {
                    $this->addFlash(
                        'success',
                        $e->getMessage()
                    );
                }
            }
        }

        return $this->render('user/editAvatar.html.twig', [
            'avatarForm' => $form,
        ]);
    }

    #[Route('/mon-compte/modifier/mot-de-passe', name: 'app_edit_password')]
    public function editPassword(Request $request): Response
    {
        $user = $this->entityManager->find(User::class, $this->getUser());

        $form = $this->createForm(EditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);

            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/editPwd.html.twig', [
            'passwordForm' => $form
        ]);
    }
}
