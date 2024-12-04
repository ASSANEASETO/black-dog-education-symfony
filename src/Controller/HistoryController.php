<?php

namespace App\Controller;


use App\Entity\History;
use App\Form\HistoryFormType;
use App\Repository\HistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HistoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-histoire', name: 'app_history', methods:['GET', 'POST'])]    
    public function index(HistoryRepository $history, Request $request, EntityManagerInterface $em): Response
    {
        $history = new History();
        $form = $this->createForm(HistoryFormType::class, $history);
        $form->handleRequest($request);

        // if ($slug === null) {
        //     $slug = 'educateur_canin';
        // }

        if ($form->isSubmitted() && $form->isValid()){
             
            $em->persist($history);
            $em->flush();

            $this->addFlash(type: 'success', message: 'votre produit a été ajouté');
            return $this->redirectToRoute('app_history', [], status: Response::HTTP_SEE_OTHER);
        }

        // Récupérer l'historique existant
        $history = $this->entityManager->getRepository(History::class)->findOneBy([]);

        // Appliquer le décodage des entités HTML et le strip_tags
        $summury = html_entity_decode(strip_tags($history->getSummury()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $content = html_entity_decode(strip_tags($history->getContent()), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Mettre à jour l'objet existingHistory avec les valeurs traitées
        $history->setSummury($summury);
        $history->setContent($content);
        
        // $history = $this->entityManager->getRepository(History::class)->findOneBy([]);
        return $this->render('history/index.html.twig', [
            'history' => $history,
            'form' => $form->createView(),
        ]);
    }
}

// $activites = ['educateur', 'comportementalist', 'canin', 'niort', '79000'];
        // educateur/comportementalist/canin/niort/79000