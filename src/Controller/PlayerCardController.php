<?php

namespace App\Controller;
use App\Entity\Player; 


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerCardController extends AbstractController
{
    
    /**
     * @Route("/Client/players/cards", name="app_player_card")
     */
    public function showPlayerCardsAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerCards = $em->getRepository(Player::class)->findAll();
        
        return $this->render('player_card/showPlayerCards.html.twig', [
            'playerCards' => $playerCards,
        ]);
    }
    /**
 * @Route("/Client/player/{id}/details", name="app_player_detail")
 */
public function showPlayerDetails($id): Response
{
    $em = $this->getDoctrine()->getManager();
    $playerDetails = $em->getRepository(Player::class)->findOneBy(['id' => $id]);
    
    if (!$playerDetails) {
        throw $this->createNotFoundException('Player not found');
    }
    return $this->render('player_details/showPlayerDetails.html.twig', [
        'playerDetails' => [$playerDetails], // Wrap the player details in an array
    ]);
}

}
