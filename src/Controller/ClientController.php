<?php

namespace App\Controller;
use App\Entity\Player;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/Client", name="Client")
     */
    public function Client(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerCards = $em->getRepository(Player::class)->findAll();
        
        return $this->render('Client/index.html.twig', [
            'playerCards' => $playerCards,
        ]);
    }
}
