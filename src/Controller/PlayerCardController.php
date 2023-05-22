<?php

namespace App\Controller;
use App\Entity\Player; 


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerCardController extends AbstractController
{
    
    /**
     * @Route("/Client/cards", name="app_player_card")
     */
    public function showPlayerCardsAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerCards = $em->getRepository(Player::class)->findAll();
        
        return $this->render('player_card/showPlayerCards.html.twig', [
            'playerCards' => $playerCards,
        ]);
    }
}
