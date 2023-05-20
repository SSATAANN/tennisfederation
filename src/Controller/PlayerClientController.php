<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerClientController extends AbstractController
{
    /**
     * @Route("/client/player", name="app_player_client")
     */
    public function index(): Response
    {
        return $this->render('player_client/index.html.twig', [
            'controller_name' => 'PlayerClientController',
        ]);
    }
}
