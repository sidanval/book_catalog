<?php

namespace AppBundle\Security;


use AppBundle\Entity\Genre;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GenreVoter extends Voter
{
    const CREATE    = 'genre_create';
    const EDIT      = 'genre_edit';
    const DELETE    = 'genre_delete';

    const SUPPORTS = [
        self::EDIT,
        self::DELETE,
        self::CREATE,
    ];

    protected function supports($attribute, $subject)
    {
        if(!in_array($attribute, self::SUPPORTS)) {
            return false;
        }

        if($attribute !== self::CREATE && !$subject instanceof Genre) {
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

        /** @var Genre $genre */
        $genre = $subject;

        switch ($attribute) {
            case self::CREATE :
            case self::EDIT :
                return true;
            case self::DELETE :
                return $this->canDelete($genre);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Genre $genre)
    {
        return !$genre->getBooks()->count();
    }
}