<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Narushevich
 * Date: 01.02.2019
 * Time: 11:19
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{

    //-- Event name for using when listening this event
    const NAME='user.register';
    /**
     * @var User
     */
    private $registeredUser;

    public function __construct(User $registeredUser)
    {
        $this->registeredUser = $registeredUser;
    }

    /**
     * @return User
     */
    public function getRegisteredUser(): User
    {
        return $this->registeredUser;
    }

}