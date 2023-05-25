<?php

namespace App\Controller;

use App\Entity\Matcch;
use App\Entity\News;
use App\Entity\Player;
use App\Repository\MatcchRepository;
use App\Repository\PlayerRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerClientController extends AbstractController
{
    /**
     * @Route("/Player/client", name="app_player_client")
     */
    public function index(UserRepository $userRepository, PlayerRepository $playerRepository, MatcchRepository $matchRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerCards = $em->getRepository(Player::class)->findAll();
        // Retrieve the logged-in user
        $user = $this->getUser();

        // Retrieve the player associated with the user
        $player = $user->getPlayer();

        // Query the matches associated with the logged-in player
        $matches = $em->getRepository(Matcch::class)->findAll();

    
        
        $news = $em->getRepository(News::class)->findAll();
        
        $totalVisitors = $userRepository->getTotalUsersByRole('ROLE_VISITOR');
        $totalPlayers = $playerRepository->getTotalPlayers();
        $totalMatches = $matchRepository->getTotalMatches();
        $totalReferee = $userRepository->getTotalUsersByRole('ROLE_REFEREE');
        
        return $this->render('player_client/index.html.twig', [
            'playerCards' => $playerCards,
            'matches' => $matches,
            'news' => $news,
            'totalVisitors' => $totalVisitors,
            'totalMatches' => $totalMatches,
            'totalPlayers' => $totalPlayers,
            'totalReferee' => $totalReferee,
        ]);
    }
}
