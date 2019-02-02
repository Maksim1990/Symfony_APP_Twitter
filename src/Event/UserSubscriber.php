<?php

namespace App\Event;


use App\Entity\UserPreferences;
use App\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{

    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var string
     */
    private $defaultLang;

    public function __construct(Mailer $mailer, EntityManagerInterface $entityManager, string $defaultLang)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->defaultLang = $defaultLang;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister',
        ];
    }


    public function onUserRegister(UserRegisterEvent $event)
    {
        $preferences= new UserPreferences();
        $preferences->setLocale($this->defaultLang);

        $user=$event->getRegisteredUser();
        $user->setPreferences($preferences);
        $this->entityManager->flush($user);

        $this->mailer->sendConfirmationEmail($event->getRegisteredUser());
    }

}