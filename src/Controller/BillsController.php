<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\Item;
use App\Entity\Service;
use App\Entity\User;
use App\Type\BillType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("has_role('ROLE_USER')")
 */
class BillsController extends AbstractController
{

    /**
     * @Route("/bills", name="bills")
     */
    public function __invoke(Request $request){
        $em = $this->getDoctrine()->getManager();
        if($this->get('security.authorization_checker')->isGranted("ROLE_ADMIN")) {
            $bills = $em->getRepository(Bill::class)->findAll();
        } else {
            $bills = $em->getRepository(Bill::class)->findBy([
                'user' => $this->get('security.token_storage')->getToken()->getUser()
            ]);
        }

        return $this->render('pages/bills.html.twig', [
            'bills' => $bills,
        ]);
    }

    /**
     * @Route("/bills-user/{id}", name="bills-user", requirements={"id":"\d+"})
     */
    public function billsUser(User $user){
        $em = $this->getDoctrine()->getManager();
        $bills = $em->getRepository(Bill::class)->findBy([
            'user' => $user
        ]);

        return $this->render('pages/bills.html.twig', [
            'bills' => $bills,
        ]);
    }

    /**
     * @Route("/bill-delete/{id}", name="bill-delete", requirements={"id":"\d+"})
     */
    public function deleteBill(Request $request, Bill $bill){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_BILL_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($bill);
        $em->flush();

        $this->addFlash('success', 'Le devis a été supprimé.');

        return $this->redirectToRoute('bills');
    }

    /**
     * @Route("/bill-create", name="bill-create")
     */
    public function createBill(){
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository(Service::class)->findAll();
        $items = $em->getRepository(Item::class)->findAll();

        return $this->render('pages/createbill.html.twig', [
            'services' => $services,
            'items' => $items,
            'previous_services' => [],
            'previous_items' => [],
            'bill_title' => '',
            'bill_description' => '',
        ]);
    }

    /**
     * @Route("/bill-modify/{id}", requirements={"id":"\d+"}, name="bill-modify")
     */
    public function modifyBill(Request $request, Bill $bill){
        $token = $request->query->get('token');
        if (($token === null)||(!$this->isCsrfTokenValid('NNC_BILL_SECURITY_TOKEN', $token))) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository(Service::class)->findAll();
        $items = $em->getRepository(Item::class)->findAll();

        return $this->render('pages/createbill.html.twig', [
            'services' => $services,
            'items' => $items,
            'previous_services' => $bill->getServices(),
            'previous_items' => $bill->getItems(),
            'bill_id' => $bill->getId(),
            'bill_title' => $bill->getName(),
            'bill_description' => $bill->getDescription(),
        ]);
    }

    /**
     * @Route("/bill-add", name="bill-add")
     */
    public function addBill(Request $request){
        $bill = new Bill();

        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository(Service::class)->findAll();

        /* @var $service Service */
        foreach($services as $service){
            $key = 'service_' . $service->getId();
            $value = $request->request->get($key);
            $this->check($value, 'service');
            if ($value){
                $bill->addService($service->getId());
                $items = $em->getRepository(Item::class)->findBy(['service' => $service->getId()]);
                /* @var $item Item */
                foreach($items as $item){
                    $key = 'item_' . $item->getId();
                    $value = $request->request->get($key);
                    $this->check($value, 'item');
                    if ($value) {
                        $bill->addItem([$item->getId() => $value]);
                    }
                }
            }
        }

        $title = $request->request->get('title');
        $title = $this->check($title, 'title');
        $bill->setName($title);

        $description = $request->request->get('description');
        $description = $this->check($description, 'description');
        $bill->setDescription($description);

        $total = $request->request->get('total');
        $total = $this->check($total, 'total');
        $bill->setPrice($total);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user instanceof User) { $bill->setUser($user); } else { $bill->setUser(null); }

        $em->persist($bill);
        $em->flush();

        if($request->request->get('withPdf') === 'withPdf') {
            $this->generatePdf($bill);
        }

        $this->addFlash('success', 'Le devis a été créé.');

        return $this->redirectToRoute('bills');
    }

    /**
     * @Route("/bill-update/{id}", requirements={"id":"\d+"}, name="bill-update")
     */
    public function updateBill(Request $request, Bill $bill){
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository(Service::class)->findAll();

        // On vide notre entité pour la reconstituée ensuite
        $bill->drop();

        /* @var $service Service */
        foreach($services as $service){
            $key = 'service_' . $service->getId();
            $value = $request->request->get($key);
            $this->check($value, 'service');
            if ($value){
                $bill->addService($service->getId());
                $items = $em->getRepository(Item::class)->findBy(['service' => $service->getId()]);
                /* @var $item Item */
                foreach($items as $item){
                    $key = 'item_' . $item->getId();
                    $value = $request->request->get($key);
                    $this->check($value, 'item');
                    if ($value) {
                        $bill->addItem([$item->getId() => $value]);
                    }
                }
            }
        }

        $title = $request->request->get('title');
        $title = $this->check($title, 'title');
        $bill->setName($title);

        $description = $request->request->get('description');
        $description = $this->check($description, 'description');
        $bill->setDescription($description);

        $total = $request->request->get('total');
        $total = $this->check($total, 'total');
        $bill->setPrice($total);

        $bill->setModificationDate(new \DateTime());

        $em->persist($bill);
        $em->flush();

        if($request->request->get('withPdf') === 'withPdf') {
            $this->generatePdf($bill);
        }

        $this->addFlash('success', 'Le devis a été modifié.');

        return $this->redirectToRoute('bills');
    }

    function check($data, $dataType)
    {
        $data = $this->clean($data);

        switch($dataType){
            case 'title':
                // on souhaite qu'un titre vide soit remplacé par une chaine aléatoire
                if ($data === '') {
                    $data = $this->randomTitle(15);
                }
                return $data;
            break;
            case 'service':
                // on souhaite qu'un titre soit "off" s'il n'est pas "on"
                if ($data !== 'on') {
                    $data = 'off';
                }
                return $data;
            break;
            case 'item':
                // on souhaite qu'un item soit exprimé en quantité, donc un entier positif
                if (!ctype_digit($data)) {
                    $data = 0;
                }
                if ($data < 0) {
                    $data = 0;
                }
                return $data;
            break;
            case 'total':
                // on souhaite qu'un total soit exprimé en valeurs, donc un entier positif
                if (!ctype_digit($data)) {
                    $data = 0;
                }
                if ($data < 0) {
                    $data = 0;
                }
                return $data;
                break;
            default:
                return $data;
            break;
        }
    }

    function clean($dirty_string)
    {
        $strip_string = strip_tags($dirty_string);
        $clean_string = htmlspecialchars($strip_string, ENT_QUOTES);

        return $clean_string;
    }

    function randomTitle($lenght) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzZ1234567890';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $lenght; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * @Route("/bill-to-pdf/{id}", requirements={"id":"\d+"}, name="bill-pdf")
     */
    public function billToPdf(Bill $bill)
    {
        $this->generatePdf($bill);
    }

    /**
     * @Route("/bill-to-pdf/test", name="bill-pdf-test")
     */
    public function testToPdf()
    {
        $this->generatePdf();
    }

    function generatePdf(Bill $bill = null) {
        $bill = $bill ?? $this->fakeBill();

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // We get our services and items
        $datas = $this->fetchBillDatas($bill);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/template.html.twig', [
            'datas' => $datas,
            'nncLogoUrl' => getenv('NNC_LOGO_URL'),
            'partnerLogoUrl' => getenv('PARTNER_LOGO_URL'),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream($bill->getName() . ".pdf", [
            "Attachment" => false
        ]);
    }

    function fakeBill() {
        $bill = new Bill();
        $bill->setName("Devis de test");
        $bill->setUser(null);
        $bill->setServices([1, 2, 4]);
        $bill->setItems([
            [1 => 10],
            [2 => 10],
            [3 => 10],
            [4 => 15],
            [6 => 25],
        ]);
        return $bill;
    }

    function fetchBillDatas(Bill $bill) {
        $datas = [
            'description' => $bill->getDescription(),
            'title' => $bill->getName(),
            'price' => 0,
            'date' => new \DateTime(),
            'services' => [],
        ];

        $em = $this->getDoctrine()->getManager();
        $mapID = 0;
        foreach($bill->getServices() as $serviceID){
            /* @var $service Service */
            $service = $em->getRepository(Service::class)->findOneBy(['id' => $serviceID]);
            $serviceDatas = []; // On instancie les datas pour ce service
            foreach($bill->getItems() as $itemKey => $itemDatas){
                /* @var $item Item */
                $item = $em->getRepository(Item::class)->findOneBy(['id' => key($itemDatas)]);
                if($item && $item->getService()->getId() === $service->getId()) {
                    $price = $item->getPrice() * current($itemDatas);
                    $datas['price'] += $price;
                    $serviceDatas[] = [
                        'name' => $item->getName(),
                        'price' => $item->getPrice(),
                        'quantity' => current($itemDatas),
                        'total' => $price
                    ];
                }
            }

            if(!$service->getService()) {
                $index = $service->getId()*10;
            } else {
                $index = 1 + $service->getService()->getId()*10;
            }

            $datas['services'][$mapID] = [
                'index' => $index,
                'name' => $service->getName(),
                'datas' => $serviceDatas
            ];
            $mapID++;
        }

        // reindex our datas permit to getting services in the right order when rendering them in the template
        sort($datas['services']);
        return $datas;
    }

    function custom_sort($a,$b) {
        return $a['index']>$b['index'];
    }
}