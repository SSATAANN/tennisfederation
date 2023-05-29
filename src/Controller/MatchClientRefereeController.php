<?php

namespace App\Controller;
use App\Entity\Matcch;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchClientRefereeController extends AbstractController
{
    /**
     * @Route("/Referee/client/matches", name="app_match_client_referee")
     */
    public function MatchRefereeAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $matches = $em->getRepository(Matcch::class)->findAll();
        
        return $this->render('match_client_referee/ShowMatchReferee.html.twig', [
            'matches' => $matches,
        ]);
    }
}
