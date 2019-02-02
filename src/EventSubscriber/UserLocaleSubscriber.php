<?php

namespace App\EventSubscriber;


use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class UserLocaleSubscriber implements EventSubscriberInterface
{

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            //  EVENT WHEN USER LOGIN
            SecurityEvents::INTERACTIVE_LOGIN=>[
                ['onInteractiveLogin', 15]
            ]
        ];
    }

    //  THIS EVENT WILL BE FIRED WHEN USER SUCCESSFULLY AUTHENTICATES
    public function onInteractiveLogin(InteractiveLoginEvent $event){

        /** @var User $user */
        $user=$event->getAuthenticationToken()->getUser();

        $this->session->set('_locale',$user->getPreferences()->getLocale());

    }
}