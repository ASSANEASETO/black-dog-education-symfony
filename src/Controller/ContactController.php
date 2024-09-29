<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Form\ContactFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $contactForm = new ContactForm();
        $form = $this->createForm(ContactFormType::class, $contactForm);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Récupérer les données du formulaire
                $subject = $form->get('subject')->getData() ?: 'No subject';

                // Sauvegarde des données dans la base de données
                $this->entityManager->persist($contactForm);
                $this->entityManager->flush();

                // Créez l'e-mail à partir des données du formulaire
                $email = (new TemplatedEmail())
                    ->from($form->get('email')->getData())
                    ->to(new Address('blackdog.educ@gmail.com', 'BLACK DOG EDUCATION'))
                    ->subject($subject)
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context([
                        'name' => $form->get('name')->getData(),
                        'number' => $form->get('number')->getData(),
                        'message' => $form->get('message')->getData(),
                        'subject' => $subject,
                        'mail' => $form->get('email')->getData(),
                    ]);

                try {
                    $this->mailer->send($email);
                    $this->addFlash('success', 'Votre email a été envoyé');
                    return $this->redirectToRoute('app_contact');
                } catch (TransportExceptionInterface $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'email');
                }
            } else {
                // Le formulaire a été soumis mais n'est pas valide
                $this->addFlash('error', 'Il y a des erreurs dans votre formulaire. Veuillez les corriger.');
            }
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}