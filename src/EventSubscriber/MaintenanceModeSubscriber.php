<?php

namespace App\EventSubscriber;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

readonly class MaintenanceModeSubscriber implements EventSubscriberInterface
{
    private ParameterBagInterface $parameterBag;
    private Environment $twig;
    public function __construct(ParameterBagInterface $parameterBag, Environment $twig) {
        $this->parameterBag = $parameterBag;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents() {
        // TODO: Implement getSubscribedEvents() method.
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $maintenanceMode = $this->parameterBag->get('MAINTENANCE_MODE') === 'true'; // À adapter selon votre implémentation

        if ($maintenanceMode && !$event->isMainRequest()) {
            // Ne pas traiter les sous-requêtes
            return;
        }

        if ($maintenanceMode) {
            // Utilisez Twig pour générer le contenu de la page de maintenance
            $content = $this->twig->render('maintenance.html.twig');
            $response = new Response($content, Response::HTTP_SERVICE_UNAVAILABLE);
            $event->setResponse($response);
        }
    }
}
