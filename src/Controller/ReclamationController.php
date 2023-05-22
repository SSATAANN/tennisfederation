<?php
// src/Controller/ReclamationController.php

namespace App\Controller;
use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    /**
     * @Route("//Admin/reclamation", name="reclamation_index")
     */
    public function index()
    {
        // Afficher une liste de réclamations existantes
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/reclamation/{id}", name="reclamation_details")
     */
    public function details($id)
    {
        // Afficher les détails d'une réclamation spécifique
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);

        if (!$reclamation) {
            throw $this->createNotFoundException('Réclamation non trouvée');
        }

        return $this->render('reclamation/details.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
     /**
     * @Route("/supPComplaint/{id}", name="app_supPComplaint")
     */
    public function suppressionPlayer(Reclamation $reclamation): Response
{
    $em = $this->getDoctrine()->getManager();
    

    $em->remove($reclamation);
    $em->flush();

    return $this->redirectToRoute('reclamation_index');
}
}


