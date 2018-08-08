<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Book;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookFavouriteController extends Controller
{
    public function addBookAction(Request $request, Book $book)
    {
        $this->toggleBook($book);

        return $this->redirect($request->headers->get('referer', '/'));
    }

    public function removeBookAction(Request $request, Book $book)
    {
        $this->toggleBook($book);

        return $this->redirect($request->headers->get('referer', '/'));
    }

    private function toggleBook(Book $book)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();
        if(!$book->getInUserFavourite($user)) {
            $user->addFavouriteBook($book);
        } else {
            $user->removeFavouriteBook($book);
        }

        $em->persist($user);
        $em->flush();
    }
}