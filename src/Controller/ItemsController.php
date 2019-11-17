<?php

namespace App\Controller;

use App\Entity\Item;
use App\Type\ItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ItemsController extends AbstractController
{
    /**
     * @Route("/items", name="items")
     */
    public function __invoke(){
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Item::class)->findAll();

        return $this->render('pages/items.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/item-delete/{id}", name="item-delete", requirements={"id":"\d+"})
     */
    public function delete(Request $request, Item $item){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_ITEM_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'L\'option a été supprimée.');

        return $this->redirectToRoute('items');
    }

    /**
     * @Route("/item-add", name="item-add")
     */
    public function add(Request $request){
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'L\'option "' . $item->getName() . '" a été créé.');

            return $this->redirectToRoute('items');
        }

        return $this->render('pages/additem.html.twig', [
            'form' => $form->createView(),
            'task' => 'Ajouter'
        ]);
    }

    /**
     * @Route("/item-update/{id}", name="item-update", requirements={"id":"\d+"})
     */
    public function update(Request $request, Item $item)
    {
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_ITEM_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'L\'option ' . $item->getName() . ' a été modifiée.');

            return $this->redirectToRoute('items');
        }

        return $this->render('pages/additem.html.twig', [
            'form' => $form->createView(),
            'task' => 'Modifier'
        ]);
    }
}