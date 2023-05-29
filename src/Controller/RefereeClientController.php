<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\RefereeRepository;
use App\Repository\PlayerRepository;
use App\Repository\MatcchRepository;
use App\Entity\Matcch;
use App\Entity\News;
use App\Entity\Player;

class RefereeClientController extends AbstractController
{
    /**
     * @Route("/referee/client", name="app_referee_client")
     */
    public function index(UserRepository $userRepository, PlayerRepository $playerRepository, MatcchRepository $matchRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerCards = $em->getRepository(Player::class)->findAll();
                // Retrieve the logged-in user
        $user = $this->getUser();

        // Retrieve the player associated with the user
        $referee = $user->getReferee();

        // Query the matches associated with the logged-in player
        $matches = $em->getRepository(Matcch::class)->findAll();

    
        
        $news = $em->getRepository(News::class)->findAll();
        
        $totalVisitors = $userRepository->getTotalUsersByRole('ROLE_VISITOR');
        $totalMatches = $matchRepository->getTotalMatches();
        $totalReferee = $userRepository->getTotalUsersByRole('ROLE_REFEREE');
        $totalPlayers = $playerRepository->getTotalPlayers();

        
        return $this->render('referee_client/index.html.twig', [
            
            'playerCards' => $playerCards,
            'matches' => $matches,
            'news' => $news,
            'totalVisitors' => $totalVisitors,
            'totalMatches' => $totalMatches,
            
            'totalReferee' => $totalReferee,
            'totalPlayers' => $totalPlayers,
        ]);
    }
}
