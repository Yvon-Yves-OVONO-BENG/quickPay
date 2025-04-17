<?php

namespace App\EventListener;

use App\Entity\AuditLog;
use App\Entity\ConstantsClass;
use App\Repository\ActionLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutListener
{
    public function __construct(
        private EntityManagerInterface $em,
        private ActionLogRepository $actionLogRepository,
        )
    {}

    #[AsEventListener(event: LogoutEvent::class)]
    public function onLogout(LogoutEvent $event): void
    {
        $user = $event->getToken()?->getUser();

        $deconnexion = $this->actionLogRepository->findOneByActionLog(['actionLog' => ConstantsClass::DECONNEXION]);
        
        if ($user) 
        {
            $log = new AuditLog();
            $log->setUser($user);
            $log->setActionLog($deconnexion);
            $log->setDateActionAt(new \DateTime());

            $this->em->persist($log);
            $this->em->flush();
        }
    }
}
