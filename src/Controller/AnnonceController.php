<?php
// src/Controller/AnnonceController.php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonces', name: 'annonces')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        $annoncesWithBase64Images = [];

        foreach ($annonces as $annonce) {
            $base64Image = null;
            if ($annonce->getImage()) {
                $base64Image = base64_encode(stream_get_contents($annonce->getImage()));
            }
            $annoncesWithBase64Images[] = [
                'annonce' => $annonce,
                'base64Image' => $base64Image,
            ];
        }

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annoncesWithBase64Images,
        ]);
    }

    #[Route('/annonces/{id}', name: 'annonce_show')]
    public function show(Annonce $annonce): Response
    {
        $base64Image = null;
        if ($annonce->getImage()) {
            $base64Image = base64_encode(stream_get_contents($annonce->getImage()));
        }

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'base64Image' => $base64Image,
        ]);
    }
}
