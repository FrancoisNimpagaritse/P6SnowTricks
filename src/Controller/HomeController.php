<?php

namespace App\Controller;

use DateTime;
use App\Entity\Figure;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\FigureRepository;
use App\Repository\MessageRepository;
use App\Repository\PictureRepository;
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
    public function show(Figure $figure, PictureRepository $repoPic, MessageRepository $repoMsg, Request $request, EntityManagerInterface $manager)
    {
        $msg = new Message();
        $messages = $repoMsg->findBy(['figure' => $figure->getId()], ['createdAt' => 'DESC']);
        $images = $repoPic->findAll();

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
            'messages' => $messages,
            'form'  => $form->createView(),
            'images' => $images
        ]);
    }
}
