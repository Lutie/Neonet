<?php

namespace App\Controller;

use App\Entity\Service;
use App\Type\ServiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ServicesController extends AbstractController
{
    /**
     * @Route("/services", name="services")
     */
    public function __invoke(){
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository(Service::class)->findAll();

        return $this->render('pages/services.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/service-delete/{id}", name="service-delete", requirements={"id":"\d+"})
     */
    public function deleteService(Request $request, Service $service){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_SERVICE_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($service);
        $em->flush();

        $this->addFlash('success', 'Le service et toutes les options qui lui sont rattachées ont été supprimés.');

        return $this->redirectToRoute('services');
    }

    /**
     * @Route("/service-add", name="service-add")
     */
    public function addService(Request $request){
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Le service "' . $service->getName() . '" a été créé.');

            return $this->redirectToRoute('services');
        }

        return $this->render('pages/addservice.html.twig', [
            'form' => $form->createView(),
            'task' => 'Ajouter'
        ]);
    }

    /**
     * @Route("/service-update/{id}", name="service-update", requirements={"id":"\d+"})
     */
    public function updateService(Request $request, Service $service)
    {
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_SERVICE_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            $this->addFlash('success', 'Le service ' . $service->getName() . ' a bien été modifié.');

            return $this->redirectToRoute('services');
        }

        return $this->render('pages/addservice.html.twig', [
            'form' => $form->createView(),
            'task' => 'Modifier'
        ]);
    }

}