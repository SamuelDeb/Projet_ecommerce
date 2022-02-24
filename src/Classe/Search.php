<?php

namespace App\Classe;


use App\Entity\Categorie;

class Search
{
    /**
     * @var string
     */
    public $texte = '';

    /**
     * @var Categorie[]
     */
    public $categories= [];
    
    public function __toString()
    {
        return $this->texte;
    }

}