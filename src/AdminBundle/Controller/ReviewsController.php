<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Reviews;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Review controller.
 *
 */
class ReviewsController extends Controller
{
    /**
     * Lists all review entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('AdminBundle:Reviews')->findAll();
       // $reviews = $em->getRepository('AdminBundle:Reviews')->findReviewsByqq($tag);
        dump($reviews);
        die;
        return $this->render('reviews/index.html.twig', array(
            'reviews' => $reviews,
        ));
    }

    /**
     * Creates a new review entity.
     *
     */
    public function newAction(Request $request)
    {
        $review = new Reviews();
        $form = $this->createForm('AdminBundle\Form\ReviewsType', $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush($review);

            return $this->redirectToRoute('reviews_show', array('id' => $review->getId()));
        }

        return $this->render('reviews/new.html.twig', array(
            'review' => $review,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a review entity.
     *
     */
    public function showAction(Reviews $review)
    {
        $deleteForm = $this->createDeleteForm($review);

        return $this->render('reviews/show.html.twig', array(
            'review' => $review,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     */
    public function editAction(Request $request, Reviews $review)
    {
        $deleteForm = $this->createDeleteForm($review);
        $editForm = $this->createForm('AdminBundle\Form\ReviewsType', $review);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reviews_edit', array('id' => $review->getId()));
        }

        return $this->render('reviews/edit.html.twig', array(
            'review' => $review,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a review entity.
     *
     */
    public function deleteAction(Request $request, Reviews $review)
    {
        $form = $this->createDeleteForm($review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($review);
            $em->flush($review);
        }

        return $this->redirectToRoute('reviews_index');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param Reviews $review The review entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reviews $review)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reviews_delete', array('id' => $review->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
