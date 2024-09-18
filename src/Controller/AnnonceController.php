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
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Récupérer les annonces paginées
        $query = $annonceRepository->createQueryBuilder('a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        $paginator = new Paginator($query);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $limit);

        // Si la page demandée dépasse le nombre de pages disponibles, ajuster
        if ($page > $pagesCount) {
            $page = $pagesCount;
            $offset = ($page - 1) * $limit;
            $query = $annonceRepository->createQueryBuilder('a')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery();
            $paginator = new Paginator($query);
        }

        // Ajouter les images à chaque annonce
        $annoncesWithImages = array_map(function (Annonce $annonce) {
            $images = [];
            foreach ($annonce->getImages() as $image) {
                $imageData = stream_get_contents($image->getData());
                if ($imageData !== false) {
                    $images[] = base64_encode($imageData);
                }
            }
            return [
                'annonce' => $annonce,
                'images' => $images,
            ];
        }, iterator_to_array($paginator));

        // Définir les pages à afficher
        $pagesToShow = $this->getPagesToShow($page, $pagesCount);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annoncesWithImages,
            'total_pages' => $pagesCount,
            'current_page' => $page,
            'pages_to_show' => $pagesToShow,
        ]);
    }

    #[Route('/annonces/{id}', name: 'annonce_show')]
    public function show(Annonce $annonce): Response
    {
        $images = [];
        foreach ($annonce->getImages() as $image) {
            $imageData = stream_get_contents($image->getData());
            if ($imageData !== false) {
                $images[] = base64_encode($imageData);
            }
        }
    
        // Utilise la méthode correcte pour récupérer les options associées
        $carOptions = $annonce->getCarOptions(); // Remplace getOptions par getCarOptions
    
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'images' => $images,
            'options' => $carOptions, // Passer les options à la vue
        ]);
    }
    
    private function getPagesToShow(int $currentPage, int $totalPages): array
    {
        $pagesToShow = [];

        if ($totalPages > 1) {
            $pagesToShow[] = 1;
            if ($currentPage > 3) {
                $pagesToShow[] = '...';
            }
            for ($i = max(2, $currentPage - 2); $i <= min($totalPages - 1, $currentPage + 2); $i++) {
                $pagesToShow[] = $i;
            }
            if ($currentPage < $totalPages - 2) {
                $pagesToShow[] = '...';
            }
            $pagesToShow[] = $totalPages;
        }

        return $pagesToShow;
    }
}
