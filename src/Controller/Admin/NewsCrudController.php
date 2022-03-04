<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $subscribe = $this->getUser()->getIsSubscribe();   
        //dd($subscribe);
        if($subscribe){
             return [
           
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
        ];
        }  
    }
    
    
}