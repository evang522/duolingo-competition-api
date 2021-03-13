<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\User\Listener;

use App\Domain\User\Entity\AdminUser;
use App\Infrastructure\Domain\User\Service\UserPasswordUpdater;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminUserListener implements EventSubscriberInterface
{
    private UserPasswordUpdater $passwordUpdater;

    public function __construct(
        UserPasswordUpdater $passwordUpdater
    ) {
        $this->passwordUpdater = $passwordUpdater;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUserPassword'],
        ];
    }

    public function setUserPassword(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (! ($entity instanceof AdminUser)) {
            return;
        }

        $this->passwordUpdater->updatePassword($entity);
    }
}
