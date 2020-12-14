<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment_index")
     */
    public function index(MessageRepository $repo): Response
    {
        $comments = $repo->findAll();

        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/admin/comment/delete/{id}", name="admin_comment_delete")
     * 
     */
    public function delete(Message $message, EntityManagerInterface $manager)
    {
        $manager->remove($message);

        $this->addFlash('success', "Le message a été supprimé avec succès.");

        $this->redirectToRoute('admin_commen_index');
    }
}
