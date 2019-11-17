<?php

namespace App\Controller;

use App\Entity\Staging;
use App\Entity\User;
use App\Type\StagingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

/**
 * //@Security("has_role('ROLE_SUPER_ADMIN')")
 */
class StagingController extends AbstractController
{
    /**
     * @Route("/stagings", name="stagings")
     */
    public function __invoke(){
        $em = $this->getDoctrine()->getManager();
        $stagings = $em->getRepository(Staging::class)->findAll();

        return $this->render('pages/stagings.html.twig', [
            'stagings' => $stagings,
        ]);
    }

    /**
     * @Route("/staging-delete/{id}", name="staging-delete", requirements={"id":"\d+"})
     */
    public function delete(Request $request, Staging $staging){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_STAGING_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($staging);
        $em->flush();

        $this->addFlash('success', 'Le staging a été supprimée.');

        return $this->redirectToRoute('stagings');
    }

    /**
     * @Route("/staging-create", name="staging-create")
     */
    public function create(Request $request){
        $staging = new Staging();
        $staging->setDate(new DateTime());

        $form = $this->createForm(StagingType::class, $staging);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->get('security.token_storage')->getToken()->getUser();
            if($user instanceof User) { $staging->setUser($user); } else { $staging->setUser(null); }

            $em = $this->getDoctrine()->getManager();
            $em->persist($staging);
            $em->flush();

            $this->addFlash('success', 'Le staging "' . $staging->getName() . '" a été créé.');

            return $this->redirectToRoute('stagings');
        }

        return $this->render('pages/addstaging.html.twig', [
            'form' => $form->createView(),
            'task' => 'Ajouter'
        ]);
    }

    /**
     * @Route("/staging-update/{id}", name="staging-update", requirements={"id":"\d+"})
     */
    public function update(Request $request, Staging $staging)
    {
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_STAGING_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(StagingType::class, $staging);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($staging);
            $em->flush();

            $this->addFlash('success', 'Le staging ' . $item->getName() . ' a été modifié.');

            return $this->redirectToRoute('stagings');
        }

        return $this->render('pages/addstaging.html.twig', [
            'form' => $form->createView(),
            'task' => 'Modifier'
        ]);
    }
}