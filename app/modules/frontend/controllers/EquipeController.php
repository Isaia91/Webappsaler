<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\ChefDeProjet;
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
                        
                            <button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal'>
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
                                        <form action='./equipe/createEquipe' method='post'>
                                            <div class='col m-2'>
                                            <label for='nomEquipe'>Nom d'équipe</label>
                                                <input type='text' class='form-control' name='nomEquipe' placeholder='Nom équipe'>
                                            </div>
                                            <div class='col m-2'>
                                                <div class='dropdown'>
                                                <label for='chefDeProjet'>Nom chef de projet</label>
                                                    <select class='form-select' name='chefDeProjet' aria-label='Default select example'>";
                                                        foreach (ChefDeProjet::find() as $cdp) {
                                                            $equipesHtml.="<option value=".$cdp->getId().">".$cdp->Collaborateur->getPrenomNom()."</option>";
                                                        }
                                                    $equipesHtml.="</select>
                                                    
                                                </div>
                                            </div>
                                        
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='submit' class='btn btn-primary'>Save</button>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                        
                        <br>";
        foreach ($nomequipes as $nomequipe) {
            $equipesHtml .= "<div class='row'>
                                <div class='col-md-6'>
                                    <h2>" . $nomequipe['nom'] ."</h2>
                                </div>
                                <div class='col-md-6'>
                                <form action='/Create/createEquipe' method='Post'>
                                    <button type='button' class='btn btn-primary' value=".$nomequipe['id'].">
                                        Modifier
                                    </button>
                                </form>
                                </div>
                            </div>";
            $equipesHtml .= "<h4>" .  " Chef de projet : ".$nomequipe['nomcdp']."</h4>";
            $equipesHtml .= "<table class='table'>
                        <thead>
                            <tr>
                                <th scope='col'>id</th>
                                <th scope='col'>Nom Prenom</th>
                                <th scope='col'>Role</th>
                            </tr>
                        </thead>
                        <tbody>";

            foreach (Equipe::find(['conditions' => 'id =' . $nomequipe['id']]) as $equipe) {

                $equipeMembers = $equipe->getEquipeMembres();
                foreach ($equipeMembers as $equipeMember) {
                    $thisRole=$equipeMember->Developpeur->getCompetence();
                    if($thisRole == "1"){
                        $thisRole="Front-End";
                    }
                    elseif($thisRole=="2"){
                        $thisRole="Back-End";
                    }
                    elseif ($thisRole=="3"){
                        $thisRole="Data base";
                    }
                    $equipesHtml .= "<tr>";
                    $equipesHtml .= "<td>" . $equipeMember->Developpeur->Collaborateur->getId() . "</td>";
                    $equipesHtml .= "<td>" . $equipeMember->Developpeur->Collaborateur->getPrenomNom() . "</td>";
                    $equipesHtml .= "<td>" . $thisRole . "</td>";
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


    public function createEquipeAction(){
        if($this->request->isPost()){
             $cdp= $this ->request ->getPost('chefDeProjet');
             $nomEquipe=$this -> request -> getPost('nomEquipe');
             $x= [] ;
             $x [] =[
                    'chefProjet' => $cdp,
                    'nomEquipe'=>$nomEquipe
            ];
             var_dump($x);
        }
    }
}

