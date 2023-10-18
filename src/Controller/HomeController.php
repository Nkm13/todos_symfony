<?php

namespace App\Controller;

use App\Services\MailLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(MailLogger $mail): Response
    {
        //$eventDispatcher->dispatch();
        $mail->sendMail();
        return $this->render('home/index.html.twig', [
            'controller_name' => $mail->sendMail(),
        ]);
    }
}