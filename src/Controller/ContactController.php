<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Type\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact")
     */
    public function __invoke(Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $html = $this->renderView('emails/contact.html.twig', [
                'email' => $contact->getEmail(),
                'message' => $contact->getMessage()
            ]);

            $message = (new \Swift_Message('Message de prise de contact'))
                ->setFrom($contact->getEmail())
                ->setTo(getenv('CONTACT_EMAIL'))
                ->setBody($html,'text/html');

            $mailer->send($message);

            $this->addFlash('success', 'Le message de prise de contact a été envoyé.');

            return $this->redirectToRoute('index');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}