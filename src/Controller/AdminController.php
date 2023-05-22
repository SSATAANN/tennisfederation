<?php

namespace App\Controller;

use App\Repository\MatcchRepository;
use App\Repository\NewsRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/Admin", name="app_admin")
     */
    public function index(UserRepository $userRepository , MatcchRepository $matchRepository , ReclamationRepository $complaintRepository , NewsRepository $newRepository): Response
    {
        $totalUsers = $userRepository->getTotalUsers();
        $totalMatches = $matchRepository->getTotalMatches();
        $totalComplaints = $complaintRepository->getTotalComplaints();
        $totalNews = $newRepository->getTotalNews();
        $totalAdmins = $userRepository->getTotalUsersByRole('ROLE_ADMIN');
        $totalVisitors = $userRepository->getTotalUsersByRole('ROLE_VISITOR');
        $totalPlayers = $userRepository->getTotalUsersByRole('ROLE_PLAYER');
        $totalReferees = $userRepository->getTotalUsersByRole('ROLE_REFEREE');

        return $this->render('Admin/index.html.twig', [
            'totalReferees' => $totalReferees,
            'totalNews' => $totalNews,
            'totalComplaints' => $totalComplaints,
            'totalMatches' => $totalMatches,
            'totalPlayers' => $totalPlayers,
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalVisitors' => $totalVisitors,
        ]);
    }



}
