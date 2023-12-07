<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType; // Importez le type de formulaire
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function register(Request $request)
    {
        // Utilisez le type de formulaire que vous avez créé
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            // Vérifiez si l'utilisateur existe déjà en base de données
            $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $formData['email']]);

            if (!$existingUser) {
                // L'utilisateur n'existe pas encore, créez une nouvelle instance de l'entité User
                $user = new User();
                $user->setEmail($formData['email']);
                $user->setPassword($formData['password']);

                // Persistez l'utilisateur dans la base de données
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                // Ajoutez la logique de gestion de session ici si nécessaire

                return $this->redirectToRoute('home');
            }

            // Ajoutez la logique de gestion de session ici si nécessaire

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
