<?php

namespace App\Controller;

use App\Entity\Terms;
use App\Form\TermsFormType;
use App\Repository\TermsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TermsController extends AbstractController
{

    #[Route('/mentions-legales', name: 'app_terms', methods:['GET', 'POST'])]

    
    public function index(TermsRepository $termsRepository, Request $request, EntityManagerInterface $em): Response
    {

        $terms = new Terms();
        $form = $this->createForm(TermsFormType::class, $terms);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($terms);
            $em->flush();

            $this->addFlash(type: 'success', message: 'votre produit a été ajouté');
            return $this->redirectToRoute('app_terms', [], status: Response::HTTP_SEE_OTHER);

        }

        $terms = $termsRepository->findAll();

        // Nettoyer le contenu avant de l'afficher
        foreach ($terms as $term) {
            $Summury = strip_tags(html_entity_decode($term->getSummury(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $Content = strip_tags(html_entity_decode($term->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $term->setSummury($Summury);
            $term->setContent($Content);
        }
        

        return $this->render('terms/index.html.twig', [
            'form' => $form->createView(),
            'safeTerm' => $term ?? 'valeur par defaut',
            'terms' => $terms,
        ]);
    }
}
