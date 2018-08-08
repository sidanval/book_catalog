<?php

namespace AppBundle\Entity;

/**
 * User
 */
class User extends \AppBundle\Model\User
{
    /**
     * @var integer
     */
    protected $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $favouriteBooks;

    /**
     * Add favouriteBook
     *
     * @param \AppBundle\Entity\Book $favouriteBook
     *
     * @return User
     */
    public function addFavouriteBook(\AppBundle\Entity\Book $favouriteBook)
    {
        $this->favouriteBooks[] = $favouriteBook;

        return $this;
    }

    /**
     * Remove favouriteBook
     *
     * @param \AppBundle\Entity\Book $favouriteBook
     */
    public function removeFavouriteBook(\AppBundle\Entity\Book $favouriteBook)
    {
        $this->favouriteBooks->removeElement($favouriteBook);
    }

    /**
     * Get favouriteBooks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavouriteBooks()
    {
        return $this->favouriteBooks;
    }
}
