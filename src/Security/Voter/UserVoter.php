<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST', 'DELET'])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // // if the user is anonymous, do not grant access
              if (!$user instanceof UserInterface) {
            return false;
         }
         if($user->getRoles()[0] === 'ROLE_SUP_ADMIN'){
        return true;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'POST':
             return $user->getRoles()[0] === 'ROLE_ADMIN' && 
             (strtoupper($subject->getRole()->getlib())=== 'CAISSIER' ||
              strtoupper($subject->getRole()->getlib())=== 'PARTENAIRE');
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                if($user->getRoles()[0]==="ROLE_CAISSIER"){
                    return false;
                }   
                break;   
            default:
                break;
        }
        return false;
    }
}