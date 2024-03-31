<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct() {
    }

    #[Route(path: '/index', name: 'index', methods: ['GET'])]
    public function index(): Response {
        return $this->render('index/index.html.twig');
    }

}
