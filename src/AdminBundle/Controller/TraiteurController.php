<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Traiteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Traiteur controller.
 *
 */
class TraiteurController extends Controller
{
    /**
     * Lists all traiteur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $traiteurs = $em->getRepository('AdminBundle:Traiteur')->findAll();

        return $this->render('traiteur/index.html.twig', array(
            'traiteurs' => $traiteurs,
        ));
    }

    /**
     * Creates a new traiteur entity.
     *
     */
    public function newAction(Request $request)
    {
        $traiteur = new Traiteur();
        $form = $this->createForm('AdminBundle\Form\TraiteurType', $traiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($traiteur);
            $em->flush();

            return $this->redirectToRoute('traiteur_show', array('id' => $traiteur->getId()));
        }

        return $this->render('traiteur/new.html.twig', array(
            'traiteur' => $traiteur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a traiteur entity.
     *
     */
    public function showAction(Traiteur $traiteur)
    {
        $deleteForm = $this->createDeleteForm($traiteur);

        return $this->render('traiteur/show.html.twig', array(
            'traiteur' => $traiteur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing traiteur entity.
     *
     */
    public function editAction(Request $request, Traiteur $traiteur)
    {
        $deleteForm = $this->createDeleteForm($traiteur);
        $editForm = $this->createForm('AdminBundle\Form\TraiteurType', $traiteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('traiteur_edit', array('id' => $traiteur->getId()));
        }

        return $this->render('traiteur/edit.html.twig', array(
            'traiteur' => $traiteur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a traiteur entity.
     *
     */
    public function deleteAction(Request $request, Traiteur $traiteur)
    {
        $form = $this->createDeleteForm($traiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($traiteur);
            $em->flush();
        }

        return $this->redirectToRoute('traiteur_index');
    }

    /**
     * Creates a form to delete a traiteur entity.
     *
     * @param Traiteur $traiteur The traiteur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Traiteur $traiteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('traiteur_delete', array('id' => $traiteur->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
