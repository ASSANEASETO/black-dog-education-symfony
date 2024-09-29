<?php

namespace App\Controller;


use App\Entity\Service;
use App\Form\ServiceFormType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    #[Route('/mes-services', name: 'app_service', methods:['GET'])]
    public function list(ServiceRepository $serviceRepository, Request $request): Response
    {

        $service = new Service();
        $form = $this->createForm(ServiceFormType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash(type: 'success', message: 'votre produit a été ajouté');
            return $this->redirectToRoute('app_service', [], status: Response::HTTP_SEE_OTHER);
        }
        // Récupérer tous les services
        $services = $serviceRepository->findAll();

        // Nettoyer le contenu avant de l'afficher
        foreach ($services as $service) {
            $Summury = strip_tags(html_entity_decode($service->getSummury(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $Description = strip_tags(html_entity_decode($service->getDescription(), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $service->setSummury($Summury);
            $service->setDescription($Description);
        }
        return $this->render('service/index.html.twig', [
            'services' => $services, 
            'form' => $form->createView(),
        ]);
    }
    
}
