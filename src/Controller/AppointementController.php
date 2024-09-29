<?php

namespace App\Controller;

use App\Entity\Appointement;
use App\Form\AppointementFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class AppointementController extends AbstractController
{
    private MailerInterface $mailer;

    private EntityManagerInterface $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager ){
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    #[Route('/rendez-vous', name: 'app_appointement')]
    public function index(Request $request): Response
    {
        $appointement = new Appointement();
        $form = $this->createForm(AppointementFormType::class, $appointement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                
            $prestationsChoices = [
                1 => 'Évaluation à domicile 35€',
                2 => 'Cours particulier. 45€',
                3 => 'Pack Chiot. 300€',
                4 => 'Pack 3 séances individuelles. 115€',
                5 => 'Pack 5 séances individuelles. 200€'
            ];
            $prestationsValue = $form->get('prestations')->getData();
            $prestationsLabel = $prestationsChoices[$prestationsValue];

            // Formatage des objets DateTime en chaînes de caractères
            $date = $form->get('date')->getData()->format('Y-m-d');
            $time = $form->get('time')->getData()->format('H:i:s');

            // Valeur par défaut si le champ age est vide
            $age = $form->get('age')->getData() ?: 'No age';

            // $userEmail = $form->get('email')->getData();

             // Persist the appointment
             $this->entityManager->persist($appointement);
             $this->entityManager->flush();

            // Créez l'e-mail à partir des données du formulaire
            $email = (new TemplatedEmail())
                // ->from(new Address('no-reply@yourdomain.com'))
                ->from($form->get('email')->getData())
                ->to(new Address('blackdog.educ@gmail.com', 'BLACK DOG EDUCATION'))
                // ->replyTo(new Address($userEmail))
                ->htmlTemplate('emails/appointement.html.twig')
                ->subject('Nouvelle demande de rendez-vous')
                ->context([
                    'name' => $form->get('name')->getData(),
                    'prestations' => $prestationsLabel,
                    'breed' => $form->get('breed')->getData(),
                    'dogNumber' => $form->get('dogNumber')->getData(),
                    'puppyNumber' => $form->get('puppyNumber')->getData(),
                    'phoneNumber' => $form->get('phoneNumber')->getData(),
                    'age' => $age,
                    // 'email' => $form->get('email')->getData(),
                    // Changer 'email' par 'userEmail'
                    'date' => $date,
                    'time' => $time,
                    ]);

                    try {
                        $this->mailer->send($email);
                        $this->addFlash('success', 'Votre rendez-vous a été envoyé');
                        return $this->redirectToRoute('app_appointement');
                    } catch (TransportExceptionInterface $e) {
                        $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email');
                    }
                }else {
                    // Le formulaire a été soumis mais n'est pas valide
                    $this->addFlash('error', 'Il y a des erreurs dans votre formulaire. Veuillez les corriger.');
                }
            }

        return $this->render('appointement/index.html.twig', [
            'form' => $form ->createView(),
        ]);
    }
}
