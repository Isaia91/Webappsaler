<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\Collaborateur;
use Test1\Models\Equipe;
use Test1\Models\Projet;
use Test1\Mvc\Controller;
class ProjetController extends \Phalcon\Mvc\Controller
{

    public function indexAction( )
    {
        $projets = [];
        foreach (Projet::find() as $projet) {
            $projets [] = [
                'id' => $projet->getId(),
                'id_developpeur'=>$projet->getIdDeveloppeur(),
                'id_chef_de_projet'=>$projet->getIdChefDeProjet(),
                'id_application' => $projet->getIdApplication(),
                'id_module' => $projet->getIdModule(),
                'id_composant' => $projet->getIdComposant(),
                'type' => $projet->getType(),
                'id_client'=>$projet->getIdClient(),
                'prix'=>$projet->getPrix(),
                'statut'=>$projet->getStatut()
            ];

        }
        $this->view->setVar('projets', $projets);
    }

}

