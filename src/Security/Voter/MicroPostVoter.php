<?php

namespace App\Security\Voter;

use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MicroPostVoter extends Voter
{
    const EDIT='edit';
    const DELETE='delete';
    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute,[self::EDIT,self::DELETE])){
            return false;
        }

        if(!$subject instanceof  MicroPost){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        /** @var MicroPost $microPost */
        $microPost=$subject;

        return $microPost->getUser()->getId() === $user->getId();
    }
}
