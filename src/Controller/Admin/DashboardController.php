<?php

namespace App\Controller\Admin;

use App\Entity\Appointement;
use App\Entity\ContactForm;
use App\Entity\Post;
use App\Entity\History;
use App\Entity\Invitation;
use App\Entity\PriceList;
use App\Entity\Service;
use App\Entity\Terms;
use App\Entity\Trouble;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin_dashboard_index', name: 'admin_dashboard_index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(PostCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Black Dog Education');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('invitaion', 'fas fa-envelope', Invitation::class);
        yield MenuItem::linkToCrud('Administrateurs', 'fas fa-user', User::class);

        yield MenuItem::linkToCrud('Blog', 'fas fa-blog', Post::class);
        yield MenuItem::linkToCrud('Mon histoire', 'fas fa-home', History::class);
        yield MenuItem::linkToCrud('Mes tarifs', 'fas fa-dollar', PriceList::class);
        yield MenuItem::linkToCrud('Mes services', 'fas fa-handshake', Service::class);
        yield MenuItem::linkToCrud('Les principaux troubles', 'fas fa-dog', Trouble::class);
        yield MenuItem::linkToCrud('Termes et conditions', 'fas fa-list', Terms::class);

        yield MenuItem::linkToCrud('Demande de contact', 'fas fa-phone', ContactForm::class);
        yield MenuItem::linkToCrud('Demande de rendez-vous', 'fas fa-users', Appointement::class);
    }
}
