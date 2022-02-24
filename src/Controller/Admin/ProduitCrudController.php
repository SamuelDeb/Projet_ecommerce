<?php

namespace App\Controller\Admin;

use App\Entity\Produit;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            TextField::new('nom'),
            SlugField::new('slug')->setTargetFieldName('nom'),
            TextField::new('subtitle'),
            TextareaField::new('description')
            ->setRequired(false),
            MoneyField::new('prix')->setCurrency('EUR'),
            IntegerField::new('quantite'),
            ImageField::new('image')
            ->setBasePath('assets/images/produits/')
            ->setUploadDir('public/assets/images/produits/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            AssociationField::new('categorie'),
            BooleanField::new('isBest'),
        ];
    }
    
}