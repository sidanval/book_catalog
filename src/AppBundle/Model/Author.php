<?php

namespace AppBundle\Model;


/**
 * Class Author
 */
class Author
{
    const GENDER_MALE       = 1;
    const GENDER_FEMALE     = 2;

    public static function genders()
    {
        return [
            self::GENDER_MALE       => 'Мужской',
            self::GENDER_FEMALE     => 'Женский',
        ];
    }

    public function getGenderLabel()
    {
        /** @var \AppBundle\Entity\Author $this */

        return self::genders()[$this->getGender()] ?? null;
    }
}