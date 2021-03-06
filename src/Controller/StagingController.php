<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\Item;
use App\Entity\Service;
use App\Type\BillType;

use App\Entity\Staging;
use App\Entity\User;
use App\Type\StagingType;
use App\Service\PdfRender;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

/**
 * @Security("has_role('ROLE_USER')")
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
            $staging->setModificationDate(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($staging);
            $em->flush();

            if ($staging->getStandardFileUpload()) {
                $standardFileUpload = $form['standard_file_upload']->getData();
                $newName = $staging->getName() . ' - standard' . '.' . $standardFileUpload->guessClientExtension();
                $standardFileUpload->move($this->getParameter('files_directory'), $newName);
                $staging->setStandardFilePath($newName);
            }

            if ($staging->getLanFileUpload()) {
                $lanFileUpload = $form['lan_file_upload']->getData();
                $newName = $staging->getName() . ' - lan' . '.' . $lanFileUpload->guessClientExtension();
                $lanFileUpload->move($this->getParameter('files_directory'), $newName);
                $staging->setLanFilePath($newName);
            }
            
            $em->persist($staging);
            $em->flush();

            $this->addFlash('success', 'Le staging "' . $staging->getName() . '" a été créé.');

            return $this->redirectToRoute('stagings');
        }

        return $this->render('pages/addstaging.html.twig', [
            'form' => $form->createView(),
            'staging' => $staging,
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
            $staging->setModificationDate(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($staging);
            $em->flush();

            if ($staging->getStandardFileUpload()) {
                $standardFileUpload = $form['standard_file_upload']->getData();
                $newName = $staging->getName() . ' - standard' . '.' . $standardFileUpload->guessClientExtension();
                $directory = $this->getParameter('kernel.project_dir') . '/web/uploads/files';
                $standardFileUpload->move($directory, $newName);
                $staging->setStandardFilePath($directory . '/' . $newName);
            }

            if ($staging->getLanFileUpload()) {
                $lanFileUpload = $form['lan_file_upload']->getData();
                $newName = $staging->getName() . ' - lan' . '.' . $lanFileUpload->guessClientExtension();
                $directory = $this->getParameter('kernel.project_dir') . '/web/uploads/files';
                $lanFileUpload->move($directory, $newName);
                $staging->setStandardFilePath($directory . '/' . $newName);
            }
            
            $em->persist($staging);
            $em->flush();

            $this->addFlash('success', 'Le staging ' . $staging->getName() . ' a été modifié.');

            return $this->redirectToRoute('stagings');
        }

        return $this->render('pages/addstaging.html.twig', [
            'form' => $form->createView(),
            'staging' => $staging,
            'task' => 'Modifier'
        ]);
    }

    /**
     * @Route("/staging-to-pdf/test", name="staging-pdf-test")
     */
    public function testToPdf()
    {
        $this->generatePdf();
    }

    /**
     * @Route("/staging-to-pdf/{id}", requirements={"id":"\d+"}, name="staging-pdf")
     */
    public function stagingToPdf(Staging $staging)
    {
        $this->generatePdf($staging);
    }

    function generatePdf(Staging $staging) {
        $html = $this->renderView('pdf/template-staging.html.twig', [
            'staging' => $staging,
            'nncLogoUrl' => getenv('NNC_LOGO_URL'),
            'partnerLogoUrl' => getenv('PARTNER_LOGO_URL'),
        ]);

        $pdfRender = new PdfRender;
        $pdfRender->generatePdf($html, $staging->getName());
    }

    function fakeStaging() {
        $staging = new Staging();
        $staging->setId(0);
        $staging->setName("Staging de test");
        $staging->setNasId("ceciestpasunid");
        $staging->setStagingType(["TV", "Wifi", "Chromcast"]);
        $staging->setUser(null);
        return $staging;
    }
}