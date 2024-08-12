<?php
namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonces', name: 'annonces')]
    public function index(AnnonceRepository $annonceRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1)); // Récupérer la page courante, par défaut 1
        $limit = 10; // Limiter à 10 annonces par page
        $offset = ($page - 1) * $limit;

        // Récupérer les annonces paginées
        $query = $annonceRepository->createQueryBuilder('a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $limit);

        $annoncesWithBase64Images = [];
        foreach ($paginator as $annonce) {
            $base64Image = null;
            if ($annonce->getImage()) {
                $base64Image = base64_encode(stream_get_contents($annonce->getImage()));
            }
            $annoncesWithBase64Images[] = [
                'annonce' => $annonce,
                'base64Image' => $base64Image,
            ];
        }

        // Définir les pages à afficher
        $pagesToShow = [];
        if ($pagesCount > 1) {
            $pagesToShow[] = 1;
            if ($page > 3) {
                $pagesToShow[] = '...';
            }
            for ($i = max(2, $page - 2); $i <= min($pagesCount - 1, $page + 2); $i++) {
                $pagesToShow[] = $i;
            }
            if ($page < $pagesCount - 2) {
                $pagesToShow[] = '...';
            }
            $pagesToShow[] = $pagesCount;
        }

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annoncesWithBase64Images,
            'total_pages' => $pagesCount,
            'current_page' => $page,
            'pages_to_show' => $pagesToShow,
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
