<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $utilisateur): void
    {
        if (!$utilisateur instanceof \App\Entity\User)
        {
            return;
        }

        if ($utilisateur->isEtat())
        {
            /////RENVOIE UNE MESSAGE 
            throw new CustomUserMessageAuthenticationException('Votre compte est désactivé.');
        }
    }

    public function checkPostAuth(UserInterface $utilisateur): void
    {
        //////a programmer
    }
}
