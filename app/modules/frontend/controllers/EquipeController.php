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
        $equipes = Equipe::find(['include' => 'chefDeProjet']);
        $this->view->setVar('equipes', $equipes);
    }

}

