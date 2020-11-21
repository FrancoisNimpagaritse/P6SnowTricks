<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Picture;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminFigureController extends AbstractController
{
    /**
     * Permet d'accéder à la liste de figure pour les administrer
     * @Route("/admin/figures", name="admin_figures_index")
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
     * @Route("/figure/new", name="admin_figure_create")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $figure = new Figure();

        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        //dd($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            foreach($figure->getPictures() as $picture)
            {
                $picture->setName('mon_image.png');
                $picture->setFigure($figure);
                $manager->persist($picture);
            }

            $slug = $slugger->slug($form->get('name')->getData())->lower();
            $figure->setSlug($slug);
            $figure->setUpdatedAt(new \DateTime());
            $figure->setAuthor($this->getUser());

            //On récupère le fichier d'image
            $file = $form->get('mainImage')->getData();
            //On récupère son ancien nom
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            //On attribue un nouveau nom à l'image
            $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();
            //On upload le fichier d'image à la destination paramétrée
            $file->move($this->getParameter('upload_directory'), $newFilename);
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
}
