<?php

namespace AppBundle\Security;


use AppBundle\Entity\Author;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AuthorVoter extends Voter
{
    const CREATE = 'author_create';
    const EDIT   = 'author_edit';
    const DELETE = 'author_delete';

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

        if($attribute !== self::CREATE && !$subject instanceof Author) {
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

        /** @var Author $author */
        $author = $subject;

        switch ($attribute) {
            case self::CREATE :
            case self::EDIT :
                return true;
            case self::DELETE :
                return $this->canDelete($author);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Author $author)
    {
        return !$author->getBooks()->count();
    }
}