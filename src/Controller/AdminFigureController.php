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
        //dd($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {

          //dd($form->get('pictures')->getData());
            //dd($request->files->get('figure')['pictures']);
            $i=0;
           
            foreach($figure->getPictures() as $picture)
            {                
                $uploadFile = $request->files->get('figure')['pictures'][$i]['imageName'];
                
                if ($uploadFile) {
                    $newPictureFilename = $uploader->upload($uploadFile);
                    $picture->setName($newPictureFilename);
                }

                $picture->setFigure($figure);
                
                $manager->persist($picture);
                $i++;
            }

            foreach($figure->getVideos() as $video)
            {
                $video->setFigure($figure);
                $manager->persist($video);
            }
            
            $figure->setAuthor($this->getUser());
            
            //On récupère le fichier de l'image principale
            $uploadMainFile = $form->get('mainImg')->getData();   
            
            if ($uploadMainFile) {
                $newMainPictureFilename = $uploader->upload($uploadMainFile);
                //On renseigne le nom qui sera en BD
                $figure->setMainImage($newMainPictureFilename);
            }
            
            $manager->persist($figure);
            $manager->flush();

            $this->addFlash('success', 'La figure <strong>' . $figure->getName() . '</strong>, ses images ainsi que ses videos ont été ajoutées avec succès !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/figure/new.html.twig', [
            'form'  =>   $form->createView()
        ]);
    }

    /**
     * Permet de modifier une figure
     * @Route("/figure/edit/{slug}", name="figure_edit")
     * @Security("is_granted('ROLE_USER') and user === figure.getAuthor()",
     * message="Cette figure ne vous appartient pas, vous ne pouvez pas la modifier !")
     * 
     * @return Response
     */
    public function edit(ImageUploader $uploader,Figure $figure, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {            
            $i=0;
            foreach($figure->getPictures() as $picture)
            {                
                $uploadedFile = $request->files->get('figure')['pictures'][$i]['imageName'];
                
                if ($uploadedFile) {
                    $newPictureFilename = $uploader->upload($uploadedFile);
                    $picture->setName($newPictureFilename);
                }

                $picture->setFigure($figure);
                
                $manager->persist($picture);
                $i++;
            }

            foreach($figure->getVideos() as $video)
            {
                $video->setFigure($figure);
                $manager->persist($video);
            }
            
            $figure->setAuthor($this->getUser());
            
            //On récupère le fichier d'image
            $uploadedMainFile = $form->get('mainImg')->getData();           
            if ($uploadedMainFile) {
                $newMainPictureFilename = $uploader->upload($uploadedMainFile);
                //On renseigne le nom qui sera en BD
                $figure->setMainImage($newMainPictureFilename);
            }
            
            $manager->persist($figure);
            $manager->flush();

            $this->addFlash('success', 'La figure <strong>' . $figure->getName() . '</strong> , ses images ainsi que ses videos ont été modifiées avec succès !');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin/figure/edit.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure
        ]);
    }

    /**
     * Permet de supprimer une figure , ses images et ses vidéos
     * @Route("/figure/delete/{slug}", name="figure_delete")
     * @Security("is_granted('ROLE_USER') and user === figure.getAuthor()",
     * message="Cette figure ne vous appartient pas, vous ne pouvez pas la supprimer !")
     */
    public function delete(Figure $figure, EntityManagerInterface $manager)
    {
        if (count($figure->getMessages()) > 0) {
            $this->addFlash('danger', "Attention ! Vous ne pouvez pas supprimer la figure <strong>{$figure->getName()}</strong> car elle possède déjà des commentaires !!!");
        } else {
            $manager->remove($figure);
            $manager->flush();
    
            $this->addFlash('success', "La figure numéro <strong> {$figure->getName()} </strong> a bien été supprimée !");    
        }

        return $this->redirectToRoute('homepage');
    }
}
