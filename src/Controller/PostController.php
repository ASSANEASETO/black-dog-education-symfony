<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/blog', name: 'app_post', methods:['GET', 'POST'])]

    public function index(PostRepository $postRepository, request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // S'assurer que le paramètre createdAt est défini
            if (!$post->getCreatedAt()) {
                $post->setCreatedAt(new DateTimeImmutable());
            }
            $em->persist($post);
            $em->flush();

            $this->addFlash(type: 'success', message: 'votre produit a été ajouté');
            return $this->redirectToRoute('app_post', [], status: Response::HTTP_SEE_OTHER);

        }

        $posts = $postRepository->findAll();

        // Nettoyer le contenu avant de l'afficher
        foreach ($posts as $post) {
            $Summary = strip_tags(html_entity_decode($post->getSummary(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $Content = strip_tags(html_entity_decode($post->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $post->setSummary($Summary);
            $post->setContent($Content);
        }

        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts,
        ]);
    }
}

 