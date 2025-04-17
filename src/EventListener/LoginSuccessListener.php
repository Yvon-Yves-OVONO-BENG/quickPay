<?php

namespace App\EventListener;

use App\Entity\AuditLog;
use App\Entity\ConstantsClass;
use App\Repository\ActionLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSuccessListener
{
    public function __construct(
        private EntityManagerInterface $em,
        private ActionLogRepository $actionLogRepository,
        )
    {}

    #[AsEventListener(event: LoginSuccessEvent::class)]
    public function onLoginSuccess(LoginSuccessEvent $event)
    {
        $user = $event->getUser();

        $connexion = $this->actionLogRepository->findOneByActionLog(['actionLog' => ConstantsClass::CONNEXION]);
        
        $log = new AuditLog();
        $log->setUser($user);
        $log->setActionLog($connexion);
        $log->setDateActionAt(new \DateTime());

        $this->em->persist($log);
        $this->em->flush();
    }
}