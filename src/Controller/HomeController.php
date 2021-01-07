<?php

namespace App\Controller;

use DateTime;
use App\Entity\Figure;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\FigureRepository;
use App\Repository\MessageRepository;
use App\Repository\PictureRepository;
use App\Service\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\HttpFoundation\Request;
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
        // Get 15 figures from position 0
        $figures = $repo->findBy([], ['updatedAt' => 'DESC'], 15, 0);
        
        return $this->render('home/index.html.twig', [
            'figures' => $figures,
        ]);
    }

    /**
     * Afficher encore 15 autres figures
     * @Route("/{start}", name="loadMoreFigures", requirements={"start": "\d+"})
     * 
     * @return Response
     */
    public function loadMoreFigures(FigureRepository $repo, $start = 15)
    {
        $figures = $repo->findBy([], ['updatedAt' => 'DESC'], 15, $start);

        return $this->render('home/loadMoreFigures.html.twig', [
            'figures' => $figures
        ]);
    }

    /**
     * Permet d'afficher les détails d'une figure
     * 
     * @Route("figure/show/{slug}/{page<\d+>?1}", name="figure_show")
     * 
     * @return Response
     */
    public function show(Figure $figure, $page, Paginator $paginator, PictureRepository $repoPic, Request $request, EntityManagerInterface $manager)
    {
        $msg = new Message();
        $paginator->setEntityClass(Message::class)
                  ->setPage($page);

        $pictures = $repoPic->findBy(['figure' => $figure]); 
        
        $form = $this->createForm(MessageType::class, $msg);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $msg->setCreatedAt(new DateTime())
                ->setFigure($figure)
                ->setUser($this->getUser());
            
            $manager->persist($msg);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('home/show.html.twig', [
            'figure' => $figure,
            'messages' => $paginator->getData(['figure' => $figure->getId()]),
            'form'  => $form->createView(),
            'pictures' => $pictures,
            'pages' => $paginator->getPages(['figure' => $figure->getId()]),
            'page'  => $page
        ]);
    }
}
