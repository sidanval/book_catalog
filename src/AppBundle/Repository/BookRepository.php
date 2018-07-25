<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Author;
use AppBundle\Entity\Genre;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormInterface;

class BookRepository extends EntityRepository
{
    public function search(FormInterface $searchForm)
    {
        $qb = $this->createQueryBuilder('b');

        $qb
            ->leftJoin('b.author', 'a')
            ->leftJoin('b.genre', 'g')
            ->addSelect('a')
            ->addSelect('g')
            ->orderBy('b.created_at', 'DESC')
            ->setMaxResults(10)
        ;

        if($genre = $searchForm->get('genre')->getData()) {
            $qb->andWhere('b.genre = :genre');
            $qb->setParameter('genre', $genre);
        }

        if($author = $searchForm->get('author')->getData()) {
            $qb->andWhere('b.author = :author');
            $qb->setParameter('author', $author);
        }

        return $qb->getQuery()->getResult();
    }

    public function byAuthor(Author $author)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->andWhere('b.author = :author');
        $qb->setParameter('author', $author);

        return $qb->getQuery()->getResult();
    }

    public function byGenre(Genre $genre)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->andWhere('b.genre = :genre');
        $qb->setParameter('genre', $genre);

        return $qb->getQuery()->getResult();
    }
}