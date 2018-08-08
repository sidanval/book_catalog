<?php

namespace AppBundle\Model;

use AppBundle\Entity\User;

class Book
{
    public function getInUserFavourite(User $user)
    {
        return $user->getFavouriteBooks()->contains($this);
    }

}