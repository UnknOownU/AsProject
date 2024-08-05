<?php
// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        // Récupérer les 3 annonces les plus récentes
        $recentAnnonces = $annonceRepository->findBy([], ['registrationDate' => 'DESC'], 6);

        return $this->render('home/index.html.twig', [
            'recentAnnonces' => $recentAnnonces,
        ]);
    }
}
