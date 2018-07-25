<?php

namespace AppBundle\Security;


use AppBundle\Entity\Book;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookVoter extends Voter
{
    const CREATE = 'book_create';
    const EDIT   = 'book_edit';
    const DELETE = 'book_delete';

    const SUPPORTS = [
        self::CREATE,
        self::EDIT,
        self::DELETE,
    ];

    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute, self::SUPPORTS)) {
            return false;
        }

        if($attribute !== self::CREATE && !$subject instanceof Book) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User) {
            return false;
        }

        return true;
    }
}