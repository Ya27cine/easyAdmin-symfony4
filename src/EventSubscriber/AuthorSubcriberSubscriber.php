<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Post;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthorSubcriberSubscriber implements EventSubscriberInterface
{
    public $tokenStorageInterface;
    public function __construct(TokenStorageInterface $tokenStorageInterface){
       $this->tokenStorageInterface = $tokenStorageInterface;
    }
    public function getUserFromToken(ViewEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if( $entity instanceof Post  && $method == Request::METHOD_POST ){
            
            $author = $this->tokenStorageInterface->getToken()->getUser();
            $entity->setAutor( $author );
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.view' => ['getUserFromToken' , EventPriorities::PRE_WRITE],
        ];
    }
}
