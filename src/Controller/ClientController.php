<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Player;
use App\Repository\MatcchRepository;
use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/Client", name="Client")
     */
    public function Client(UserRepository $userRepository , PlayerRepository $playerRepository , MatcchRepository $matchRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerCards = $em->getRepository(Player::class)->findAll();
        $news = $em->getRepository(News::class)->findAll();

        
        $totalVisitors = $userRepository->getTotalUsersByRole('ROLE_VISITOR');
        $totalPlayers = $playerRepository->getTotalPlayers();
        $totalMatches = $matchRepository->getTotalMatches();
        $totalReferee = $userRepository->getTotalUsersByRole('ROLE_REFEREE');
        
        return $this->render('Client/index.html.twig', [
            'playerCards' => $playerCards,
            'news' => $news,
            'totalVisitors' => $totalVisitors,
            'totalMatches' => $totalMatches,
            'totalPlayers' => $totalPlayers,
            'totalReferee' => $totalReferee
            
        ]);
    }

 
}
