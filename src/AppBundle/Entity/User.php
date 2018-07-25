<?php

namespace AppBundle\Entity;

/**
 * User
 */
class User extends \FOS\UserBundle\Model\User
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
}
