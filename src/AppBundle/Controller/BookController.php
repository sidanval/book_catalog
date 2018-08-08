<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Author;
use AppBundle\Entity\Genre;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Book controller.
 *
 */
class BookController extends Controller
{
    /**
     * Lists all book entities.
     *
     */
    public function indexAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Book');

        $searchForm = $this->createForm('AppBundle\Form\Search\BookType');
        $searchForm->handleRequest($request);

        $books = $repository->search($searchForm);

        return $this->render('book/index.html.twig', array(
            'books'         => $books,
            'searchForm'    => $searchForm->createView(),
        ));
    }

    public function authorAction(Request $request, Author $author)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Book');

        $books = $repository->byAuthor($author);

        return $this->render('book/author.html.twig', array(
            'books'     => $books,
            'author'    => $author,
        ));
    }

    public function genreAction(Request $request, Genre $genre)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Book');

        $books = $repository->byGenre($genre);

        return $this->render('book/genre.html.twig', array(
            'books'     => $books,
            'genre'    => $genre,
        ));
    }

    /**
     * Creates a new book entity.
     *
     * @Security("is_granted('book_create')")
     */
    public function newAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm('AppBundle\Form\BookType', $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('book_show', array('id' => $book->getId()));
        }

        return $this->render('book/new.html.twig', array(
            'book' => $book,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a book entity.
     *
     */
    public function showAction(Book $book)
    {
        $deleteForm = $this->createDeleteForm($book);

        return $this->render('book/show.html.twig', array(
            'book' => $book,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing book entity.
     *
     * @Security("is_granted('book_edit', book)")
     */
    public function editAction(Request $request, Book $book)
    {
        $deleteForm = $this->createDeleteForm($book);
        $editForm = $this->createForm('AppBundle\Form\BookType', $book);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_edit', array('id' => $book->getId()));
        }

        return $this->render('book/edit.html.twig', array(
            'book' => $book,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a book entity.
     *
     * @Security("is_granted('book_delete', book)")
     */
    public function deleteAction(Request $request, Book $book)
    {
        $form = $this->createDeleteForm($book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('book_index');
    }

    /**
     * Creates a form to delete a book entity.
     *
     * @param Book $book The book entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Book $book)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', array('id' => $book->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
