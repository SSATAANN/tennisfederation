<?php

namespace App\Controller;

use App\Form\MatcchType;
use App\Entity\Matcch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class MatchClientController extends AbstractController
{
    /**
     * @Route("/match/client", name="app_match_client")
     */
    public function MatchAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $matches = $em->getRepository(Matcch::class)->findAll();
        
        return $this->render('match_client/ShowMatch.html.twig', [
            'matches' => $matches,
        ]);
    }
    //--------------------

/**
 * @Route("/match/{id}/result", name="match_result")
 */
public function getResult(Matcch $match, Request $request): Response
{
    $resultat = $match->getResultat();
    $etat = $match->getEtat();

    $jsonData = ['resultat' => $resultat, 'etat' => $etat];

    if ($request->isXmlHttpRequest()) {
        return new JsonResponse($jsonData);
    } else {
        return $this->render('match_client/result.html.twig', [
            'match' => $match, // Pass the 'match' variable to the template
        ]);
    }
}


    //--------------------
}
