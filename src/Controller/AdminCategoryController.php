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
     * @Route("/admin/categories", name="admin_categories_index")
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
     * @Route("/admin/categories/new", name="admin_categories_create")
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

            return $this->redirectToRoute('admin_categories_index');
        }
            return $this->render('admin/category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier une catégorie de figures
     * @Route("admin/categories/edit/{id}", name="admin_categories_edit")
     * 
     * @return Response
     */
    public function edit(Category $category, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('succes', 'La catégorie <strong>' . $category->getName() . '</strong> a été ajoutée avec succès !');

            return $this->redirectToRoute('admin_categories_index');            
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * Permet de supprimer une catégorie
     * @Route("/admin/category/delete/{id}", name="admin_categories_delete")
     *
     * @return  Response
     */
    public function delete(Category $category, EntityManagerInterface $manager)
    {
        if (count($category->getFigures()) > 0) {
            $this->addFlash('danger', "Attention ! Vous ne pouvez pas supprimer la catégorie <strong>{$category->getName()}</strong> car elle possède déjà des figures !!!");
        } else {
            $manager->remove($category);
            $manager->flush();
    
            $this->addFlash('success', "La catégorie <strong> {$category->getName()} </strong> a bien été supprimée !");    
        }

        return $this->redirectToRoute('admin_categories_index');
    }
}
