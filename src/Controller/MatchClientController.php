<?php

namespace App\Controller;

use App\Form\MatcchType;
use App\Entity\Matcch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
