<?php
declare(strict_types=1);

namespace Test1\modules\frontend\controllers;
use Test1\Models\Client;
use Test1\Models\Collaborateur;
use Test1\Models\Equipe;
use Test1\Models\Projet;
use Test1\Mvc\Controller;
class ClientController extends \Phalcon\Mvc\Controller
{

    public function indexAction( )
    {
        $clientsHtml="
                        <table class='table'>
                            <thead>
                            <tr>
                                <th scope='col'>id</th>
                                <th scope='col'>raisonsocial</th>
                                <th scope='col'>ridet</th>
                                <th scope='col'>ssi2</th>
                            </tr>
                            </thead>";
        //$clients=[];
        foreach (Client::find() as $client) {
                    $clientsHtml.="<tr>";
                    $clientsHtml.="<td>".$client->getId()."</td>";
                    $clientsHtml.="<td>".$client->getRaisonSocial()."</td>";
                    $clientsHtml.="<td>".$client->getRidet()."</td>";
                    $clientsHtml.="<td>".$client->getSsi2()."</td>";
                    $clientsHtml.="</tr>";


        }
        $clientsHtml.="</table>";
        $this->view->setVar('clientsHtml', $clientsHtml);
    }

}

