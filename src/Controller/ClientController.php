<?php

namespace App\Controller;

use App\Entity\Client;
use App\Type\ClientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/clients", name="clients")
     */
    public function __invoke(){
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository(Client::class)->findAll();

        return $this->render('pages/clients.html.twig', [
            'clients' => $clients,
        ]);
    }

    /**
     * @Route("/client-delete/{id}", name="client-delete", requirements={"id":"\d+"})
     */
    public function delete(Request $request, Client $client){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_CLIENT_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        $this->addFlash('success', 'Le client a été supprimé.');

        return $this->redirectToRoute('clients');
    }

    /**
     * @Route("/client-add", name="client-create")
     */
    public function add(Request $request){
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'Le client "' . $client->getName() . '" a été créé.');

            return $this->redirectToRoute('clients');
        }

        return $this->render('pages/addclient.html.twig', [
            'form' => $form->createView(),
            'task' => 'Ajouter'
        ]);
    }

    /**
     * @Route("/client-update/{id}", name="client-update", requirements={"id":"\d+"})
     */
    public function update(Request $request, Client $client)
    {
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_CLIENT_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'Le client ' . $client->getName() . ' a été modifiée.');

            return $this->redirectToRoute('clients');
        }

        return $this->render('pages/addclient.html.twig', [
            'form' => $form->createView(),
            'task' => 'Modifier'
        ]);
    }
}