<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Service\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comments_index")
     */
    public function index(MessageRepository $repo, $page, Paginator $paginator): Response
    {
        //$comments = $repo->findAll(); supprimer et le repo
        $paginator->setEntityClass(Message::class)
                ->setPage($page);

        return $this->render('admin/comment/index.html.twig', [
            'comments' =>  $paginator->getData(),
            'pages' => $paginator->getPages(),
            'page'  => $page
        ]);
    }

    /**
     * Permet de supprimer un commentaire
     * @Route("/admin/comments/delete/{id}", name="admin_comments_delete")
     * 
     */
    public function delete(Message $message, EntityManagerInterface $manager)
    {
        $manager->remove($message);
        $manager->flush();

        $this->addFlash('success', "Le message a été supprimé avec succès.");

        return $this->redirectToRoute('admin_comments_index');
    }
}
