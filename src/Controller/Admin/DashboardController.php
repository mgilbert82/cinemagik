<?php

namespace App\Controller\Admin;

use App\Controller\Admin\PostCrudController;
use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Director;
use App\Entity\Media;
use App\Entity\Post;
use App\Entity\Source;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(PostCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cinemagik');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour à CINEMAGIK', 'fa fa-home', 'app_home');
        yield MenuItem::submenu('Articles', 'fas fa-film')
            ->setSubItems([
                MenuItem::linkToCrud('Tous les articles', 'fas fa-film', Post::class),
                MenuItem::linkToCrud('Ecrire un article', 'fas fa-plus', Post::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        yield MenuItem::submenu('Réalisateurs', 'fas fa-bullhorn')
            ->setSubItems([
                MenuItem::linkToCrud('Tous les réalisateurs', 'fas fa-user', Director::class),
                MenuItem::linkToCrud('Ajouter un réalisateur', 'fas fa-plus', Director::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        yield MenuItem::submenu('Acteurs', 'fas fa-user-astronaut')
            ->setSubItems([
                MenuItem::linkToCrud('Tous les acteurs', 'fas fa-user', Actor::class),
                MenuItem::linkToCrud('Ajouter un acteur', 'fas fa-plus', Actor::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        yield MenuItem::submenu('Genres', 'fas fa-masks-theater')
            ->setSubItems([
                MenuItem::linkToCrud('Tous les genres', 'fas fa-list', Category::class),
                MenuItem::linkToCrud('Ajouter un genre', 'fas fa-plus', Category::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        yield MenuItem::submenu('Médias', 'fas fa-image')
            ->setSubItems([
                MenuItem::linkToCrud('Les médias', 'fas fa-list', Media::class),
                MenuItem::linkToCrud('Enregistrer une image', 'fas fa-plus', Media::class)
                    ->setAction(Crud::PAGE_NEW)
            ]);
        yield MenuItem::submenu('Plateforme', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Toutes les plateformes', 'fas fa-list', Source::class),
                MenuItem::linkToCrud('Ajouter une plateforme', 'fas fa-plus', Source::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        yield MenuItem::submenu('Compte utilisateurs', 'fas fa-user')
            ->setSubItems([
                MenuItem::linkToCrud('Tous les utilisateurs', 'fas fa-user-friends', User::class),
                MenuItem::linkToCrud('Modifier un utilisateur', 'fas fa-plus', User::class)
                    ->setAction(Crud::PAGE_EDIT),
            ]);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Comment::class);
    }
}
