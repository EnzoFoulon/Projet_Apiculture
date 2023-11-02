<?php
// src/Controller/ApiculteurController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiculteurController extends AbstractController
{
    /**
     * @Route("/templates", name="apiculteur_account")
     */
    public function apiculteurAccount()
    {
        // Récupérez ici les données de l'apiculteur et ses ruches (positions, etc.) depuis votre base de données
        $apiculteurData = // Fetch apiculteur data from the database
        $ruchesData = // Fetch ruches data from the database

        return $this->render('apiculteur/account.html.twig', [
            'apiculteur' => $apiculteurData,
            'ruches' => $ruchesData,
        ]);
    }
}
