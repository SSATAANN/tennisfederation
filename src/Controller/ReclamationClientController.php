<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ReclamationClientController extends AbstractController
{
    /**
     * @Route("/Client/addReclamation", name="app_addReclamation")
     */
    public function create(Request $request,Security $security): Response
    {
        // Get the current user (assuming you have a way to retrieve the authenticated user)
        $user = $security->getUser();
        if ($user !== null) {
            // Accéder à la propriété "email" de l'utilisateur
            
            // Utiliser l'email comme nécessaire
            // ...
        } else {
            // Gérer le cas où l'utilisateur n'est pas connecté
            // Par exemple, rediriger vers une page de connexion ou afficher un message d'erreur
            return $this->render('security/login.html.twig');
        }

        // Create a new Reclamation entity
        $reclamation = new Reclamation();
        $reclamation->setUser($user);

        // Create the form
        $form = $this->createForm(ReclamationFormType::class, $reclamation);

        // Handle the form submission
        $form->handleRequest($request);

        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Save the Reclamation entity to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            // Redirect to a success page or perform any additional actions
            return $this->redirectToRoute('Client');
        }

        // Render the form in your template
        return $this->render('reclamation_client/index.html.twig', ['form' => $form->createView()]);
    }

    
}