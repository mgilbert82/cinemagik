<?php

namespace App\EventSubscriber;

use App\Entity\Post;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PostEventListener implements EventSubscriber
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Post) {
            $token = $this->tokenStorage->getToken();

            if ($token !== null) {
                $user = $token->getUser();

                if ($user) {
                    $entity->setUser($user);
                }
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Post) {
            $token = $this->tokenStorage->getToken();

            if ($token !== null) {
                $user = $token->getUser();

                if ($user) {
                    $entity->setUser($user);
                }
            }
        }
    }
}
