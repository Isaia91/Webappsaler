<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\Collaborateur;
use Test1\Models\Developpeur;
use Test1\Models\Projet;
use Test1\Mvc\Controller;
class DeveloppeurController extends \Phalcon\Mvc\Controller
{

    public function indexAction( )
    {
        $developpeurs = Developpeur::find();
        $this->view->setVar('developpeurs', $developpeurs);
    }

}

