<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\User;
use App\Entity\Adresse;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Categorie;
use App\Entity\Transporteur;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;



class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;
    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $url = $this->adminUrlGenerator
            -> setController(UserCrudController::class)
            -> generateUrl();
            
         return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('dashboard/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Manga Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Mangashop');
        yield MenuItem::subMenu('Utilisateurs', 'fas fa-list', User::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', User::class)
            ]);
            
        
        yield MenuItem::subMenu('Categorie', 'fas fa-list', Categorie::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Categorie::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Categorie::class)
            ]);
        
        yield MenuItem::subMenu('Produit', 'fas fa-list', Produit::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Produit::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Produit::class)
            ]);
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);

        yield MenuItem::subMenu('Adresse', 'fas fa-list', Adresse::class)
            ->setSubItems([
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Adresse::class) 
                            ->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Adresse::class)
            ]);

        yield MenuItem::subMenu('transporteur', 'fas fa-list', Transporteur::class)
        ->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Transporteur::class) 
                        ->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Transporteur::class)
        ]);
        yield MenuItem::subMenu('Commande', 'fas fa-list', Commande::class)
        ->setSubItems([
            
            MenuItem::linkToCrud('Visualiser', 'fas fa-eye', Commande::class)
        ]);
      
    }
}