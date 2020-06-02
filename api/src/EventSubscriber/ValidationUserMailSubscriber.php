<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ValidationUserMailSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['verifyAccount', EventPriorities::POST_WRITE],
        ];
    }

    public function verifyAccount(ViewEvent $event): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) {
            return;
        }

        $message = (new \Swift_Message('Recruit App rh : registration'))
            ->setFrom('recruitapprh@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(sprintf('To validate your registration, please click on this <a href="%s/%s">link/a>.', 'http://localhost:8081/verifyAccount', $user->getToken()));

        $this->mailer->send($message);
    }
}