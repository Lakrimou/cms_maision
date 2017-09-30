<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\AgenceVoyage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Agencevoyage controller.
 *
 */
class AgenceVoyageController extends Controller
{
    /**
     * Lists all agenceVoyage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agenceVoyages = $em->getRepository('AdminBundle:AgenceVoyage')->findAll();

        return $this->render('agencevoyage/index.html.twig', array(
            'agenceVoyages' => $agenceVoyages,
        ));
    }

    /**
     * Creates a new agenceVoyage entity.
     *
     */
    public function newAction(Request $request)
    {
        $agenceVoyage = new Agencevoyage();
        $form = $this->createForm('AdminBundle\Form\AgenceVoyageType', $agenceVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agenceVoyage);
            $em->flush();

            return $this->redirectToRoute('agencevoyage_show', array('id' => $agenceVoyage->getId()));
        }

        return $this->render('agencevoyage/new.html.twig', array(
            'agenceVoyage' => $agenceVoyage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agenceVoyage entity.
     *
     */
    public function showAction(AgenceVoyage $agenceVoyage)
    {
        $deleteForm = $this->createDeleteForm($agenceVoyage);

        return $this->render('agencevoyage/show.html.twig', array(
            'agenceVoyage' => $agenceVoyage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agenceVoyage entity.
     *
     */
    public function editAction(Request $request, AgenceVoyage $agenceVoyage)
    {
        $deleteForm = $this->createDeleteForm($agenceVoyage);
        $editForm = $this->createForm('AdminBundle\Form\AgenceVoyageType', $agenceVoyage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agencevoyage_edit', array('id' => $agenceVoyage->getId()));
        }

        return $this->render('agencevoyage/edit.html.twig', array(
            'agenceVoyage' => $agenceVoyage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a agenceVoyage entity.
     *
     */
    public function deleteAction(Request $request, AgenceVoyage $agenceVoyage)
    {
        $form = $this->createDeleteForm($agenceVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agenceVoyage);
            $em->flush();
        }

        return $this->redirectToRoute('agencevoyage_index');
    }

    /**
     * Creates a form to delete a agenceVoyage entity.
     *
     * @param AgenceVoyage $agenceVoyage The agenceVoyage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AgenceVoyage $agenceVoyage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('agencevoyage_delete', array('id' => $agenceVoyage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
