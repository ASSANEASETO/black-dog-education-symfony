<?php

namespace App\Controller;

use App\Entity\PriceList;
use App\Form\PriceListFormType;
use App\Repository\PriceListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PriceListController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/tarifs-quel-prix', name: 'app_price_list', methods:['GET', 'POST'])]

    public function list(PriceListRepository $priceListRepository, request $request, EntityManagerInterface $entityManager): Response
    {
        $priceList = new PriceList();
       
        // Créez et gérez le formulaire
        $form = $this->createForm(PriceListFormType::class, $priceList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($priceList);
            $entityManager->flush();

            $this->addFlash(type: 'success', message: 'votre produit a été ajouté');
            return $this->redirectToRoute('app_price_list', [], status: Response::HTTP_SEE_OTHER);

        }
        
        // Récupérer tous les tarifs existants
        $priceLists = $priceListRepository->findAll();

        // Si vous voulez nettoyer les données existantes, faites-le dans une boucle
        foreach ($priceLists as $priceList) {
            $summury = html_entity_decode(strip_tags($priceList->getSummury()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $description = html_entity_decode(strip_tags($priceList->getDescription()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            
            $priceList->setSummury($summury);
            $priceList->setDescription($description);
        }

        // Si vous avez modifié des entités existantes, vous devez les persister
        $this->entityManager->flush();
        return $this->render('price_list/index.html.twig', [
            'form' => $form->createView(),
            'priceList' => $priceList,
            'priceLists' => $priceLists, 
        ]);
    }
}
