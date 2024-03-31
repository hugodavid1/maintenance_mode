<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaintenanceController extends AbstractController
{
    public function __construct(private ParameterBagInterface $p)
    {
    }
    #[Route('/maintenance', name: 'maintenance_index', requirements: ['url' => '.*'], priority: 1000)]
    public function index(): Response
    {
        $value = $this->p->get('MAINTENANCE_MODE_CONTROLLER');
        if ($value) {
            return $this->redirectToRoute('/maintenance');
        }
        return $this->redirectToRoute('/');
    }

}
