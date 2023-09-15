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
        $equipesHtml .="<button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#createModale'>
                                Créer une équipe
                         </button>";
        $equipesHtml .="<br>";
        $equipesHtml .="<div class='modal fade' id='createModale' tabindex='-1' aria-labelledby='createModaleLabel' aria-hidden='true'>";
        $equipesHtml .="<div class='modal-dialog'>";
        $equipesHtml .="<div class='modal-content'>";
        $equipesHtml .="<div class='modal-header'>";
        $equipesHtml .="<h5 class='modal-title' id='createModaleLabel'>Créer une équipe</h5>";
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



        /*$equipesHtml .="<onestla>";  Permet de savoir ou l'on se trouve dans le html */
        $equipesHtml .="<br>";
        foreach ($nomequipes as $nomequipe) {
            $equipesHtml .="<div class='row'>";
            $equipesHtml .="<div class='col-md-6'>";
            $equipesHtml .="<h2>" . $nomequipe['nom'] ."</h2>";
            $equipesHtml .="</div>";
            $equipesHtml .="<div class='col-md-3'>";
            $equipesHtml .="<button type='button' name='alter' data-bs-toggle='modal' data-bs-target='#alterModale".$nomequipe['id']."' class='btn btn-primary' value=".$nomequipe['id'].">";
            $equipesHtml .="Modifier";
            $equipesHtml .="</button>";
            /*$equipesHtml .= "<a href='" . $this->url->get('/test1/equipe/updateEquipe/'). "'class='btn btn-primary'>Modifier</a>";*/
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
                //Modal pour modifier une equipe
                $equipesHtml .="<div class='modal fade' id='alterModale".$nomequipe['id']."' tabindex='-1' aria-labelledby='alterModaleLabel' aria-hidden='true'>";
                $equipesHtml .="<div class='modal-dialog'>";
                $equipesHtml .="<div class='modal-content'>";
                $equipesHtml .="<div class='modal-header'>";
                $equipesHtml .="<h5 class='modal-title' id='alterModaleLabel'>Modifier une équipe : ". $nomequipe['nom']."</h5>";
                $equipesHtml .="<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                $equipesHtml .="</div>";
                $equipesHtml .="<div class='modal-body'>";
                $equipesHtml .="<form action='/test1/equipe/updateEquipe' method='post'>";
                $equipesHtml .="<div class='col m-2'>";
                $equipesHtml .="<label for='nomEquipe'>Nom d'équipe</label>";
                $equipesHtml .="<input type='number' name='id' class='form-control' style='display:none;' value='".$nomequipe['id']."'>";
                $equipesHtml .="<input type='text' class='form-control' name='nomEquipe' value='".$nomequipe['nom']."' placeholder='".$nomequipe['nom']."'>";
                $equipesHtml .="</div>";
                $equipesHtml .="<div class='col m-2'>";
                $equipesHtml .="<div class='dropdown'>";
                $equipesHtml .="<label for='chefDeProjet'>Nom chef de projet</label>";
                $equipesHtml .="<select class='form-select' name='chefDeProjet' aria-label='Default select example' selected='".$nomequipe['cdp']."'>";
                foreach (ChefDeProjet::find() as $cdp) {
                    $selected = ($cdp->getId() == $nomequipe['cdp']) ? 'selected' : '';
                    $equipesHtml .= "<option value=".$cdp->getId()." $selected>".$cdp->Collaborateur->getPrenomNom()."</option>";
                }
                $equipesHtml .="</select>";

                $equipesHtml .="</div>";
                $equipesHtml .="</div>";
                $equipesHtml .="<div class='col m-2'>";
                $equipesHtml .="<div class='dropdown'>";
                $i=1;
                foreach (Developpeur::find() as $dev) {
                    $equipesHtml .= "<br><input type='checkbox' value=".$dev->getId()." id='checkbox".$i."' name='membresEquipe[]' /> ";
                    $equipesHtml .= "<label for='checkbox".$i."'>".$dev->Collaborateur->getPrenomNom()."</label>";
                    $i++;
                }

                $equipesHtml .="</select>";
                $equipesHtml .="</div>";
                $equipesHtml .="</div>";
                $equipesHtml .="</div>";
                $equipesHtml .="<div class='modal-footer'>";
                $equipesHtml .="<button type='submit' class='btn btn-primary'>Save</button>";
                $equipesHtml .="</div>";
                $equipesHtml .="</form>";
                $equipesHtml .="</div>";
                $equipesHtml .="</div>";
                $equipesHtml .="</div>";

                //Modal pour modifier une equipe
            }
            $equipesHtml .= "</tbody>";
            $equipesHtml .= "</table>";
            $equipesHtml .= "<br> <br>";
        }

        $equipesHtml.="</table>";
        $this->view->setVar('equipesHtml', $equipesHtml);
    }

    private function equipeChecker(int $equipeId) {
        $thisEquipe = Equipe::findFirst($equipeId);

        if ($thisEquipe) {
            $thisCdp = $thisEquipe->getChefDeProjetId();
            $thisEquipeMembers = $thisEquipe->getEquipeMembres();

            foreach (Equipe::find() as $equipe) {
                if ($equipe->getId() != $equipeId) {
                    $equipeMembers = $equipe->getEquipeMembres();

                    if ($equipe->getChefDeProjetId() === $thisCdp) {
                        foreach ($thisEquipeMembers as $thisEquipeMember) {
                            foreach ($equipeMembers as $equipeMember) {
                                if ($thisEquipeMember->getIdDeveloppeur() === $equipeMember->getIdDeveloppeur()) {
                                    return "Impossible d'associer le membre d'équipe à cette équipe car ils sont déjà dans l'équipe " . $equipe->getNom();
                                }
                            }
                        }
                    }
                }
            }

            return true; // La vérification est réussie
        }

        return "L'équipe avec l'ID spécifié n'existe pas.";
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
        if($this->request->isPost()){
            $equipeId = $this->request->getPost('id');

            $equipe = Equipe::findFirst($equipeId);

            if (!$equipe) {
                $this->response->redirect('/test1/equipe');
            }
            if ($this->equipeChecker($equipeId)){
                // Récupére les champs du formulaire
                $nomEquipe = $this->request->getPost('nomEquipe');
                $chefDeProjetId = $this->request->getPost('chefDeProjet');
                $membresEquipe = $this->request->getPost('membresEquipe');

                // Vérifier si au moins un membre d'équipe est coché pour pas que l'equipe soit vide
                if (empty($membresEquipe)) {
                    //redirection vers la page d'accueil
                    return $this->response->redirect('/test1/equipe');
                }

                // Mettre à jour les propriétés de l'équipe
                $equipe->setNom($nomEquipe);
                $equipe->setChefDeProjetId($chefDeProjetId);

                // Supprimer les membres actuels de l'équipe
                $equipeMembres = $equipe->getEquipeMembres();
                foreach ($equipeMembres as $equipeMembre) {
                    $equipeMembre->delete();
                }

                // Ajout des nouveaux membres a k'equipe
                foreach ($membresEquipe as $devId) {
                    $equipeMembre = new EquipeMembres();
                    $equipeMembre->setIdEquipe($equipeId);
                    $equipeMembre->setIdDeveloppeur($devId);
                    $equipeMembre->save();
                }

                // Sauvegarder l'équipe
                if ($equipe->save()) {
                    return $this->response->redirect('/test1/equipe');
                } else {
                    echo "Erreur lors de la mise à jour de l'équipe.";
                    foreach ($equipe->getMessages() as $message) {
                        echo $message, "<br>";
                    }
                }
            }
            else{
                echo "vous ne pouvez pas assosier ce chef d'equipe avec ce membre d'equipe";
            }
        }
    }



    public function deleteEquipeAction()
    {
        if($this->request->isPost()) {
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
}

