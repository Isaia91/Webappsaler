<?php
declare(strict_types=1);

namespace Test1\Modules\Frontend\Controllers;
use Test1\Models\ChefDeProjet;
use Test1\Models\Collaborateur;
use Test1\Models\Developpeur;
use Test1\Models\Equipe;
use Test1\Models\Projet;
use Test1\Models\EquipeMembres;
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
                                        <form action='/test1/equipe/save' method='post'>
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
                                            </div>";
                                            $equipesHtml .= "<div class='col m-2'>
                                                                <div class='dropdown'>";
                                                                        $i=1;
                                                                        foreach (Developpeur::find() as $dev) {
                                                                            $equipesHtml .= "<br><input type='checkbox' value=".$dev->getId()." id='checkbox".$i."' name='membresEquipe[]' />
                                                                                                <label for='checkbox".$i."'>".$dev->Collaborateur->getPrenomNom()."</label>";
                                                                            $i++;
                                                                        }

                                                                    $equipesHtml.="</select>
                                                    
                                                </div>
                                            </div>";
                                            $equipesHtml .= "</div>
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
                                <div class='col-md-3'>
                                <form action='./equipe/UpdateEquipe' method='Post'>
                                    <button type='submit' class='btn btn-primary' value=".$nomequipe['id'].">
                                        Modifier
                                    </button>
                                </form>
                                </div>
                                <div class='col-md-3'>
                                <form action='./equipe/deleteEquipe' method='Post'>
                                    <button type='submit' name='supprimer' class='btn btn-danger' value=".$nomequipe['id'].">
                                        Supprimer
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


    public function saveAction(){
        if($this->request->isPost()){
            $cdp= $this ->request ->getPost('chefDeProjet');
            $nomEquipe=$this -> request -> getPost('nomEquipe');
            $equipe = new Equipe();
            $equipe->setChefDeProjetId($cdp);
            $equipe->setNom($nomEquipe);

            if ($equipe->save()) {
                // Succès : l'équipe a été enregistrée avec succès en base de données
                $equipeId=$equipe->getId();
                $selectedDeveloppeurs = $this->request->getPost('membresEquipe');

                    foreach ($selectedDeveloppeurs as $devId) {
                        $equipeMembre = new EquipeMembres();
                        $equipeMembre->setIdEquipe($equipeId);
                        $equipeMembre->setIdDeveloppeur($devId);
                        $equipeMembre->save();
                    }
                    $this->response->redirect('/test1/equipe');
                return;
            } else {
                // Échec : il y a eu une erreur lors de l'enregistrement en base de données
                echo "Erreur lors de l'enregistrement de l'équipe.";
                // Vous pouvez également afficher les erreurs de validation en cas d'échec.
                foreach ($equipe->getMessages() as $message) {
                    echo $message, "<br>";
                }
            }
        }
    }

    public function updateEquipeAction(){

    }
    public function deleteEquipeAction()
    {
        $id=$this->request->getPost('supprimer');
        $equipe = Equipe::findFirst($id);
        if (!$equipe) {
            return $this->response->redirect('error-page');
        }

        // Supprimez l'équipe de la base de données
        if ($equipe->delete()) {
            return $this->response->redirect('test1/equipe');
        } else {
            echo "Erreur lors de la suppression de l'équipe.";
            // Vous pouvez également afficher les erreurs de suppression en cas d'échec.
            foreach ($equipe->getMessages() as $message) {
                echo $message, "<br>";
            }
        }

    }
}

