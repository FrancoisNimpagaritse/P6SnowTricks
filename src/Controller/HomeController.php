<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Affiche le liste des figures
     * 
     * @Route("/", name="homepage")
     * 
     * @return Response
     */
    public function index(FigureRepository $repo)
    {
        $figures = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'figures' => $figures,
        ]);
    }

    /**
     * Permet d'afficher les détails d'une figure
     * 
     * @Route("figure/show/{slug}", name="figure_show")
     * 
     * @return Response
     */
    public function show(Figure $figure)
    {
        return $this->render('home/show.html.twig', [
            'figure' => $figure,
        ]);
    }
}
