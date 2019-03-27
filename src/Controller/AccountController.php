<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/account", name="account")
     */
    public function __invoke(){

        return $this->render('pages/account.html.twig');

    }

}