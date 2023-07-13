<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\Collaborateur;
use Test1\Models\Projet;
use Test1\Mvc\Controller;
class CollaborateurController extends \Phalcon\Mvc\Controller
{

    public function indexAction( )
    {
        $collaborateurs = Collaborateur::find();
        $this->view->setVar('collaborateurs', $collaborateurs);
    }

}

