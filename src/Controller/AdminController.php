<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/Admin", name="app_admin")
     */
    public function index(UserRepository $userRepository): Response
    {
        $totalUsers = $userRepository->getTotalUsers();
        $totalAdmins = $userRepository->getTotalUsersByRole('ROLE_ADMIN');
        $totalVisitors = $userRepository->getTotalUsersByRole('ROLE_VISITOR');

        return $this->render('Admin/index.html.twig', [
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalVisitors' => $totalVisitors,
        ]);
    }



}
