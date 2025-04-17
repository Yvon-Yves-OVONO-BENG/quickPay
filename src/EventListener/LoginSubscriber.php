<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Security\Http\SecurityEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSubscriber
{
    public function __construct(
        private Security $security,
        private RequestStack $requestStack
        )
    {}

    public static function getSubscribedEvent(): array{
        return [ 
            SecurityEvents::INTERACTIVE_LOGIN => 'onLoginSuccess'
        ];
    }

    public function onLoginSuccess(InteractiveLoginEvent $event): void
    {
        /**
         * @var User
         */
        $user = $this->security->getUser();

        $session = $this->requestStack->getSession();

        if ($user instanceof User) 
        {
            if (empty($user->getCode()) && empty($user->getNumCni()) && empty($user->getContact())) 
            {
                $session->getFlashBag()->add('incomplete_profile', 'Merci de compléter votre compte (CNI et Code de transfert');
            }
        }
    }
}