<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="categories_index")
     */
    public function index(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Permet de créer une nouvelle catégorie
     * @Route("/admin/categories/new", name="categories_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'La catégorie <strong>' . $category->getName() . '</strong> a été ajoutée avec succès !');

            return $this->redirectToRoute('categories_index');
        }
            return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
