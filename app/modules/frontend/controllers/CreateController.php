<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\ChefDeProjet;
use Test1\Models\Collaborateur;
use Test1\Models\Equipe;
use Test1\Models\Projet;
use Test1\Mvc\Controller;
class CreateController extends \Phalcon\Mvc\Controller
{

    public function indexAction( )
    {
        $x="world";
        $this->view->setVar('hello',$x);
    }

    public function createEquipe(){
        if($this->request->isPost()){
            /*
             * $cdp= $this ->request ->getPost('chefDeProjet');
             * $nomEquipe=$this -> request -> getPost('nomEquipe');

              */
            $x=1;
            var_dump($x);
        }
    }
}

