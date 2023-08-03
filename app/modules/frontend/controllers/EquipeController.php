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

        $equipesHtml = "<br>";
        $equipesHtml .="<button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                Créer une équipe
                         </button>";
        $equipesHtml .="<br>";
        $equipesHtml .="<div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
        $equipesHtml .="<div class='modal-dialog'>";
        $equipesHtml .="<div class='modal-content'>";
        $equipesHtml .="<div class='modal-header'>";
        $equipesHtml .="<h5 class='modal-title' id='exampleModalLabel'>Modal title</h5>";
        $equipesHtml .="<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        $equipesHtml .="</div>";
        $equipesHtml .="<div class='modal-body'>";
        $equipesHtml .="<form action='/test1/equipe/createEquipe' method='post'>";
        $equipesHtml .="<div class='col m-2'>";
        $equipesHtml .="<label for='nomEquipe'>Nom d'équipe</label>";
        $equipesHtml .="<input type='text' class='form-control' name='nomEquipe' placeholder='Nom équipe'>";
        $equipesHtml .="</div>";
        $equipesHtml .="<div class='col m-2'>";
        $equipesHtml .="<div class='dropdown'>";
        $equipesHtml .="<label for='chefDeProjet'>Nom chef de projet</label>";
        $equipesHtml .="<select class='form-select' name='chefDeProjet' aria-label='Default select example'>";
        foreach (ChefDeProjet::find() as $cdp) {
            $equipesHtml .="<option value=".$cdp->getId().">".$cdp->Collaborateur->getPrenomNom()."</option>";
                                                        }
        $equipesHtml .="</select>";

        $equipesHtml .="</div>";
        $equipesHtml .="</div>";
        $equipesHtml .= "<div class='col m-2'>";
        $equipesHtml .="<div class='dropdown'>";
        $i=1;
        foreach (Developpeur::find() as $dev) {
            $equipesHtml .= "<br><input type='checkbox' value=".$dev->getId()." id='checkbox".$i."' name='membresEquipe[]' />
            <label for='checkbox".$i."'>".$dev->Collaborateur->getPrenomNom()."</label>";
            $i++;
                                                                        }

        $equipesHtml .="</select>";
        $equipesHtml .="</div>";
        $equipesHtml .="</div>";
        $equipesHtml .= "</div>";
        $equipesHtml .="<div class='modal-footer'>";
        $equipesHtml .="<button type='submit' class='btn btn-primary'>Save</button>";
        $equipesHtml .="</div>";
        $equipesHtml .="</form>";
        $equipesHtml .="</div>";
        $equipesHtml .="</div>";
        $equipesHtml .="</div>";
        $equipesHtml .="<br>";
        foreach ($nomequipes as $nomequipe) {
            $equipesHtml .="<div class='row'>";
            $equipesHtml .="<div class='col-md-6'>";
            $equipesHtml .="<h2>" . $nomequipe['nom'] ."</h2>";
            $equipesHtml .="</div>";
            $equipesHtml .="<div class='col-md-3'>";
            $equipesHtml .="<form action='./equipe/UpdateEquipe' method='Post'>";
            $equipesHtml .="<button type='submit' class='btn btn-primary' value=".$nomequipe['id'].">
                                        Modifier
                             </button>";
            $equipesHtml .="</form>";
            $equipesHtml .="</div>";
            $equipesHtml .="<div class='col-md-3'>";
            $equipesHtml .="<form action='./equipe/deleteEquipe' method='Post'>";
            $equipesHtml .="<button type='submit' name='supprimer' class='btn btn-danger' value=".$nomequipe['id'].">
                                        Supprimer
                             </button>";
            $equipesHtml .="</form>";
            $equipesHtml .="</div>";
            $equipesHtml .="</div>";
            $equipesHtml .="<h4>" .  " Chef de projet : ".$nomequipe['nomcdp']."</h4>";
            $equipesHtml .="<table class='table'>";
            $equipesHtml .="<thead>";
            $equipesHtml .="<tr>";
            $equipesHtml .="<th scope='col'>id</th>";
            $equipesHtml .="<th scope='col'>Nom Prenom</th>";
            $equipesHtml .="<th scope='col'>Role</th>";
            $equipesHtml .="</tr>";
            $equipesHtml .="</thead>";
            $equipesHtml .="<tbody>";

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
            $equipe = new Equipe();
            $equipe->setChefDeProjetId($cdp);
            $equipe->setNom($nomEquipe);

            if ($equipe->save()) {
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
                echo "Erreur lors de l'enregistrement de l'équipe.";
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
        $id = $this->request->getPost('supprimer');
        $equipe = Equipe::findFirst($id);
        if (!$equipe) {
            return $this->response->redirect('error-page');
        }
        //Il faut d'abord supprimer les membres d'equipe avant de supprimer l'equipe
        $equipeMembres = $equipe->getEquipeMembres();
        foreach ($equipeMembres as $equipeMembre) {
            $equipeMembre->delete();
        }

        // Ensuite, supprimez l'équipe
        if ($equipe->delete()) {
            return $this->response->redirect('test1/equipe');
        } else {
            echo "Erreur lors de la suppression de l'équipe.";
            foreach ($equipe->getMessages() as $message) {
                echo $message, "<br>";
            }
        }
    }
}

