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

        $equipesHtml = "";
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
            $equipesHtml .= "<br>";
        }

        /*
        foreach (Equipe::find() as $equipe) {
            $equipesHtml.="<tr>";
            $equipesHtml.="<td>".$equipe->getId()."</td>";
            $equipesHtml.="<td>".$equipe->getChefDeProjetId()."</td>";
            $equipesHtml.="<td>".$equipe->getNom()."</td>";
            $equipesHtml.="<td>".$equipe->Chefdeprojet->Collaborateur->getPrenomNom()."</td>";
            $equipesHtml.="</tr>";


            $equipes [] = [
                'id' => $equipe->getId(),
                'chefDeProjet_id'=>$equipe->getChefDeProjetId(),
                'nom'=>$equipe->getNom(),
                'cdp' => $equipe->Chefdeprojet->Collaborateur->getPrenomNom()
            ];

        }*/
        $equipesHtml.="</table>";
        $this->view->setVar('equipesHtml', $equipesHtml);
    }

}

