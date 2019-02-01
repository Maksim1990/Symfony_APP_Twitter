<?php

namespace App\Security;


use App\Exceptions\UserNotEnabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{


    public function checkPreAuth(UserInterface $user)
    {

        if(!$user->isEnabled()){
            throw new UserNotEnabledException('Disbaled');
        }

    }

    public function checkPostAuth(UserInterface $user)
    {
      return true;
    }
}