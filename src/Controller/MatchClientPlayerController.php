<?php

namespace App\Controller;

use App\Entity\Matcch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class MatchClientPlayerController extends AbstractController
{
    /**
     * @Route("/Player/client/matches", name="app_match_client_player")
     */
    public function MatchPlayerAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $matches = $em->getRepository(Matcch::class)->findAll();
        
        return $this->render('match_client_player/ShowMatchPlayer.html.twig', [
            'matches' => $matches,
        ]);
    }

}
