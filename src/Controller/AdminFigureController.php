<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Picture;
use App\Form\FigureType;
use App\Service\ImageUploader;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminFigureController extends AbstractController
{
    /**
     * Permet d'accéder à la liste de figure pour les administrer
     * @Route("/admin/figures", name="figures_index")
     * 
     * @return Response
     */
    public function index(FigureRepository $repo): Response
    {
        $figures = $repo->findAll();

        return $this->render('admin/figure/index.html.twig', [
            'figures' => $figures
        ]);
    }

    /**
     * Permet de créer une figure
     * @Route("/figure/new", name="figure_create")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function create(Request $request, ImageUploader $uploader, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $figure = new Figure($slugger);

        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($figure->getPictures() as $picture)
            {
                $picture->setName('mon_image.png');
                $picture->setFigure($figure);
                $manager->persist($picture);
            }

            $figure->setAuthor($this->getUser());

            //On récupère le fichier d'image
            $file = $form->get('mainImage')->getData();

            $newFilename = $uploader->upload($file);           
            
            //On renseigne le nom qui sera en BD
            $figure->setMainImage($newFilename);

            $manager->persist($figure);

            $manager->flush();

            $this->addFlash('success', 'La figure a été ajoutée avec succès !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/figure/new.html.twig', [
            'form'  =>   $form->createView()
        ]);
    }

    /**
     *Permet de modifier une figure
     *@Route("/figure/edit/{slug}", name="figure_edit")
     *@Security("is_granted('ROLE_USER') and user === figure.getAuthor()",
     *message="Cette figure ne vous appartient pas, vous ne pouvez pas la modifier !")
     * 
     * @return Response
     */
    public function edit(ImageUploader $uploader,Figure $figure, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        dd($form->get('mainImage'));
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($figure->getPictures() as $picture)
            {
                $picture->setName('mon_image.png');
                $picture->setFigure($figure);
                $manager->persist($picture);
            }

            $figure->setAuthor($this->getUser());

            //On récupère le fichier d'image
            $file = $form->get('mainImage')->getData();

            $newFilename = $uploader->upload($file);

            $figure->setMainImage($newFilename);

            $manager->persist($figure);

            $manager->flush();

            $this->addFlash('success', 'La figure a été modifiée avec succès !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/figure/edit.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure
        ]);
    }
}
