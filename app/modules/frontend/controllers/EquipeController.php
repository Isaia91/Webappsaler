<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\Collaborateur;
use Test1\Models\Equipe;
use Test1\Models\Projet;
use Test1\Mvc\Controller;
class EquipeController extends \Phalcon\Mvc\Controller
{

    public function indexAction( )
    {
        $equipes = [];
        foreach (Equipe::find() as $equipe) {
            $equipes [] = [
                'id' => $equipe->getId(),
                'chefDeProjet_id'=>$equipe->getChefDeProjetId(),
                'nom'=>$equipe->getNom(),
                'cdp' => $equipe->Chefdeprojet->Collaborateur->getPrenomNom()
            ];

        }
        $this->view->setVar('equipes', $equipes);
    }

}

