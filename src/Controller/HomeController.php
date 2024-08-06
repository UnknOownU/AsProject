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
        // Récupérer les 6 annonces les plus récentes
        $recentAnnonces = $annonceRepository->findBy([], ['registrationDate' => 'DESC'], 6);

        // Convertir les images BLOB en base64
        foreach ($recentAnnonces as $annonce) {
            if ($annonce->getImage()) {
                $annonce->base64Image = base64_encode(stream_get_contents($annonce->getImage()));
            } else {
                $annonce->base64Image = null;
            }
        }

        return $this->render('home/index.html.twig', [
            'recentAnnonces' => $recentAnnonces,
        ]);
    }
}
