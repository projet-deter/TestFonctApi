<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Offer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class TokenOfferGenerator implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['generateOfferToken', EventPriorities::PRE_WRITE],
        ];
    }

    public function generateOfferToken(ViewEvent $event): void
    {
        $offer = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$offer instanceof Offer || Request::METHOD_POST !== $method) {
            return;
        }

        $token = bin2hex(random_bytes(16));
        $offer->setToken($token);

    }
}