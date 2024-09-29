<?php

namespace App\Controller;

use App\Entity\Trouble;
use App\Form\TroubleFormType;
use App\Repository\TroubleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TroubleController extends AbstractController
{
   
    #[Route('/troubles-du-comportement', name: 'app_trouble', methods:['GET', 'POST'])]
    public function list(TroubleRepository $troubleRepository, Request $request, EntityManagerInterface $em): Response
    {
        $trouble = new Trouble();
        $form = $this->createForm(TroubleFormType::class, $trouble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($trouble);
            $em->flush();

            $this->addFlash(type: 'success', message: 'votre produit a été ajouté');
            return $this->redirectToRoute('app_trouble', [], status: Response::HTTP_SEE_OTHER);

        }

        $troubles = $troubleRepository->findAll();

        // Nettoyer le contenu avant de l'afficher
        foreach ($troubles as $trouble) {
            $Summury = strip_tags(html_entity_decode($trouble->getSummury(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $Content = strip_tags(html_entity_decode($trouble->getContent(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $trouble->setSummury($Summury);
            $trouble->setContent($Content);
        }
        return $this->render('trouble/index.html.twig', [
            'form' => $form->createView(),
            'troubles' => $troubles,
        ]);
     }
}
