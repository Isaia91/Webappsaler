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

        $nomequipes = [];
        foreach (Equipe::find() as $equipe) {
            $nomequipes [] = [
                'id' => $equipe->getId(),
                'nom'=>$equipe->getNom(),
                'cdp'=>$equipe->getChefDeProjetId(),
                'nomcdp'=>$equipe->Chefdeprojet->Collaborateur->getPrenomNom()
            ];
            }

        $equipesHtml = "<br>
                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                            Créer une équipe
                        </button>
                        <br>
                        <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Modal title</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form>
                                            <div class='col m-2'>
                                                <input type='text' class='form-control' placeholder='Nom équipe'>
                                            </div>
                                            <div class='col m-2'>
                                                <div class='dropdown'>
                                                    <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        Chef d'équipe
                                                    </button>
                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenu2'>
                                                        <button class='dropdown-item' type='button'>Action</button>
                                                        <button class='dropdown-item' type='button'>Another action</button>
                                                        <button class='dropdown-item' type='button'>Something else here</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                        <button type='button' class='btn btn-primary'>Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>";
        foreach ($nomequipes as $nomequipe) {
            $equipesHtml .= "<h2>" . $nomequipe['nom'] ."</h2>";
            $equipesHtml .= "<h4>" .  " Chef de projet : ".$nomequipe['nomcdp']."</h4>";
            $equipesHtml .= "<table class='table'>
                        <thead>
                            <tr>
                                <th scope='col'>id</th>
                                <th scope='col'>Nom Prenom</th>
                            </tr>
                        </thead>
                        <tbody>";

            foreach (Equipe::find(['conditions' => 'id =' . $nomequipe['id']]) as $equipe) {

                $equipeMembers = $equipe->getEquipeMembres();
                foreach ($equipeMembers as $equipeMember) {
                    $equipesHtml .= "<tr>";
                    $equipesHtml .= "<td>" . $equipeMember->Developpeur->Collaborateur->getId() . "</td>";
                    $equipesHtml .= "<td>" . $equipeMember->Developpeur->Collaborateur->getPrenomNom() . "</td>";
                    $equipesHtml .= "</tr>";
                }
            }
            $equipesHtml .= "</tbody>";
            $equipesHtml .= "</table>";
            $equipesHtml .= "<br> <br>";
        }

        $equipesHtml.="</table>";
        $this->view->setVar('equipesHtml', $equipesHtml);
    }

}

