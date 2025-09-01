<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\Item;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Client;
use App\Type\BillType;
use App\Service\PdfRender;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("has_role('ROLE_SUPER_ADMIN')")
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
        $clients = $em->getRepository(Client::class)->findAll();

        return $this->render('pages/createbill.html.twig', [
            'services' => $services,
            'items' => $items,
            'clients' => $clients,
            'previous_client' => null,
            'previous_services' => [],
            'previous_items' => [],
            'bill_title' => '',
            'bill_description' => '',
            'bill_number' => '',
            'purchase_order' => '',
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
        $clients = $em->getRepository(Client::class)->findAll();

        return $this->render('pages/createbill.html.twig', [
            'services' => $services,
            'items' => $items,
            'clients' => $clients,
            'previous_client' => $bill->getClient(),
            'previous_services' => $bill->getServices(),
            'previous_items' => $bill->getItems(),
            'bill_id' => $bill->getId(),
            'bill_title' => $bill->getName(),
            'bill_description' => $bill->getDescription(),
            'bill_number' => $bill->getBillNumber(),
            'purchase_order' => $bill->getPurchaseOrder(),
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

        $client = $em->getRepository(Client::class)->findOneBy(['id' => $request->request->get('client')]);
        $bill->setClient($client);

        $description = $request->request->get('description');
        $description = $this->check($description, 'description');
        $bill->setDescription($description);

        $total = $request->request->get('total');
        $total = $this->check($total, 'total');
        $bill->setPrice($total);

        $billNumber = $request->request->get('bill_number');
        $billNumber = $this->check($billNumber, 'bill_number');
        $bill->setBillNumber($billNumber);

        $purchaseOrder = $request->request->get('purchase_order');
        $purchaseOrder = $this->check($purchaseOrder, 'purchase_order');
        $bill->setBillNumber($purchaseOrder);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user instanceof User) { $bill->setUser($user); } else { $bill->setUser(null); }

        $em->persist($bill);
        $em->flush();

        $this->addFlash('success', 'Le devis a été créé.');

        if($request->request->get('withPdf') === 'withPdf') {
            $this->generatePdf($bill);
        }

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

        $client = $em->getRepository(Client::class)->findOneBy(['id' => $request->request->get('client')]);
        $bill->setClient($client);

        $description = $request->request->get('description');
        $description = $this->check($description, 'description');
        $bill->setDescription($description);

        $total = $request->request->get('total');
        $total = $this->check($total, 'total');
        $bill->setPrice($total);

        $purchaseOrder = $request->request->get('purchaseOrder');
        $purchaseOrder = $this->check($purchaseOrder, 'purchaseOrder');
        $bill->setPurchaseOrder($purchaseOrder);

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
        $clean_string = strip_tags($dirty_string);
        //$clean_string = htmlspecialchars($clean_string, ENT_QUOTES);

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
     * @Route("/invoice-to-pdf/{id}", requirements={"id":"\d+"}, name="invoice-pdf")
     */
    public function invoiceToPdf(Bill $bill)
    {
        $this->generatePdf($bill);
    }

    /**
     * @Route("/invoice-to-pdf/test", name="invoice-pdf-test")
     */
    public function testInvoiceToPdf()
    {
        $this->generatePdf();
    }

    /**
     * @Route("/bill-to-pdf/{id}", requirements={"id":"\d+"}, name="bill-pdf")
     */
    public function billToPdf(Bill $bill)
    {
        if (!$bill->getPurchaseOrder()) {
            $this->addFlash('danger', 'La facture ne peux être créée car un numéro de commande (ordre achat) est nécessaire.');
            return $this->redirectToRoute('bills');
        }
        $this->generatePdf($bill, true);
    }

    /**
     * @Route("/bill-to-pdf/test", name="bill-pdf-test")
     */
    public function testBillToPdf()
    {
        $this->generatePdf(null, true);
    }

    function generatePdf(Bill $bill = null, $fullBill = false) {
        $em = $this->getDoctrine()->getManager();
        $bill = $bill ?? $this->fakeBill();
        $docTypeName = $fullBill ? "Facture" : "Devis";

        if (!$bill->getFullBillDate()) {
            $now = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
            $bill->setFullBillDate($now);

            // bornes du mois en cours
            $from = $now->modify('first day of this month midnight');
            $to   = $from->modify('first day of next month midnight');

            // on compte les factures déjà émises ce mois-ci
            $count = $em->getRepository(Bill::class)->createQueryBuilder('b')
                ->select('COUNT(b.id)')
                ->andWhere('b.fullBillDate >= :from')
                ->andWhere('b.fullBillDate < :to')
                ->setParameter('from', $from)
                ->setParameter('to', $to)
                ->getQuery()
                ->getSingleScalarResult();

            $seq = (int)$count + 1; // la nouvelle facture est la suivante

            // numéro au format YYYYMMDD#### (#### = compteur mensuel zero-padded 4)
            $billNumber = $now->format('Ymd') . str_pad((string)$seq, 4, '0', STR_PAD_LEFT);
            $bill->setBillNumber($billNumber);
            $em->flush();
        }

        // We get our services and items
        $datas = $this->fetchBillDatas($bill);
        $datas['billNumber'] = $bill->getBillNumber();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/template-bill.html.twig', [
            'fullBill' => $fullBill,
            'datas' => $datas,
            'addressTop' => getenv('ADDRESS_TOP'),
            'addressBottom' => getenv('ADDRESS_BOTTOM'),
            'siren' => getenv('SIREN'),
            'billEmail' => getenv('BILL_EMAIL'),
            'billPhone' => getenv('CONTACT_PHONE'),
            'nncLogoUrl' => getenv('NNC_LOGO_URL'),
            'partnerLogoUrl' => getenv('PARTNER_LOGO_URL'),
            'bankName' => getenv('BANK_NAME'),
            'bankIban' => getenv('BANK_IBAN'),
            'bankBic' => getenv('BANK_BIC'),
            'tvaIntracom' => getenv('TVA_INTRACOM'),
            'bill' => $bill,
        ]);

        $old = error_reporting();
        error_reporting($old & ~E_WARNING);
        $pdfRender = new PdfRender;
        $pdfRender->generatePdf($html, $docTypeName . " °" . $bill->getBillNumber() . " " . $bill->getName());
        error_reporting($old);
    }

    function fakeBill() {
        $bill = new Bill();
        $bill->setId(0);
        $bill->setName("Test");
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
            'client' => $bill->getClient(),
            'title' => $bill->getName(),
            'price' => 0,
            'date' => new \DateTime(),
            'services' => [],
            'number' => sprintf("%'.06d\n", $bill->getId()),
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

        $datas['tva'] = getenv('TVA_VALUE');
        $datas['price_from_tva'] = $datas['price'] * $datas['tva'] / 100;
        $datas['price_with_tva'] = $datas['price'] + $datas['price_from_tva'];

        // reindex our datas permit to getting services in the right order when rendering them in the template
        sort($datas['services']);
        return $datas;
    }

    function custom_sort($a,$b) {
        return $a['index']>$b['index'];
    }

    /**
     * @Route("/bills/{id}/set-po", name="bill_set_po", methods={"POST"})
     */
    public function setPurchaseOrder(Bill $bill, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        // Sécurité CSRF
        if (!$this->isCsrfTokenValid('set_po_'.$bill->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('CSRF token invalide.');
        }

        $po = trim((string) $request->request->get('purchaseOrder'));
        if ($po === '') {
            $this->addFlash('warning', 'La valeur ne peut pas être vide.');
            return $this->redirectToRoute('bills');
        }

        $bill->setPurchaseOrder($po);
        $em->flush();
        $this->addFlash('success', 'Bon de commande enregistré.');

        return $this->redirectToRoute('bills');
    }
}