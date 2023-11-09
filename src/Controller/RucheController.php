<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ruche;
use App\Entity\Intervention;
use App\Entity\Recolte;

class RucheController extends AbstractController
{
    /**
     * @Route("/ruches", name="afficher_ruches")
     */
    public function afficherRuches(EntityManagerInterface $entityManager)
    {
        // Récupérer la liste des ruches depuis la base de données
        $ruches = $entityManager->getRepository(Ruche::class)->findAll();

        return $this->render('ruche/afficher_ruches.html.twig', [
            'ruches' => $ruches,
        ]);
    }

    /**
     * @Route("/ajouter_ruche", name="ajouter_ruche")
     */
    public function ajouterRuche(Request $request, EntityManagerInterface $entityManager)
    {
        // Code pour ajouter une ruche
        if ($request->isMethod('POST')) {
            $nomRuche = $request->request->get('nomRuche');
            $positionRuche = $request->request->get('positionRuche');

            // Créer une nouvelle instance de Ruche
            $nouvelleRuche = new Ruche();
            $nouvelleRuche->setNom($nomRuche);
            $nouvelleRuche->setPosition($positionRuche);

            // Enregistrer la nouvelle ruche dans la base de données
            $entityManager->persist($nouvelleRuche);
            $entityManager->flush();

            return $this->redirectToRoute('afficher_ruches');
        }

        return $this->render('ruche/ajouter_ruche.html.twig');
    }

    /**
     * @Route("/supprimer_ruche/{rucheId}", name="supprimer_ruche")
     */
    public function supprimerRuche(Request $request, EntityManagerInterface $entityManager, $rucheId)
    {
        // Récupérez la ruche depuis la base de données en fonction de $rucheId
        $ruche = $entityManager->getRepository(Ruche::class)->find($rucheId);

        if (!$ruche) {
            throw $this->createNotFoundException('Ruche non trouvée.');
        }

        // Supprimez les interventions liées à la ruche
        $interventions = $entityManager->getRepository(Intervention::class)->findBy(['ruche' => $ruche]);
        foreach ($interventions as $intervention) {
            $entityManager->remove($intervention);
        }

        // Supprimez les récoltes liées à la ruche
        $recoltes = $entityManager->getRepository(Recolte::class)->findBy(['ruche' => $ruche]);
        foreach ($recoltes as $recolte) {
            $entityManager->remove($recolte);
        }

        // Supprimez la ruche elle-même
        $entityManager->remove($ruche);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Ruche supprimée avec succès']);
    }
}
