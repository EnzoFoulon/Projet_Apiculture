<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\LoginType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
                // get the last username entered by the user
                $lastUsername = $authenticationUtils->getLastUsername();

                $form = $this->createForm(LoginType::class, [
                    // You can prefill the form fields here if needed
                    'username' => $lastUsername,
                ]);
        
                $form->handleRequest($request);
        
                if ($form->isSubmitted() && $form->isValid()) {
                    // The form has been submitted and is valid, you can handle the login logic here
                    // Typically, you would authenticate the user, set up a session, and redirect to a secure area
                    // For example:
                    // $user = $this->getUser();
                    // $this->addFlash('success', 'Welcome ' . $user->getUsername());
                    // return $this->redirectToRoute('secure_area_route');
                }
        
                return $this->render('security/login.html.twig', [
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'form' => $form->createView(),
                ]);
            }
             /**
     * @Route("/", name="homepage")
     */
    public function homepage(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // get the last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, [
            // You can prefill the form fields here if needed
            'username' => $lastUsername,
        ]);

        return $this->render('security/homepage.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }
        }
        