<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\FoyerPrive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Foyerprive controller.
 *
 */
class FoyerPriveController extends Controller
{
    /**
     * Lists all foyerPrive entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $foyerPrives = $em->getRepository('AdminBundle:FoyerPrive')->findAll();

        return $this->render('foyerprive/index.html.twig', array(
            'foyerPrives' => $foyerPrives,
        ));
    }

    /**
     * Creates a new foyerPrive entity.
     *
     */
    public function newAction(Request $request)
    {
        $foyerPrive = new Foyerprive();
        $form = $this->createForm('AdminBundle\Form\FoyerPriveType', $foyerPrive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($foyerPrive);
            $em->flush($foyerPrive);

            return $this->redirectToRoute('foyerprive_show', array('id' => $foyerPrive->getId()));
        }

        return $this->render('foyerprive/new.html.twig', array(
            'foyerPrive' => $foyerPrive,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a foyerPrive entity.
     *
     */
    public function showAction(FoyerPrive $foyerPrive)
    {
        $deleteForm = $this->createDeleteForm($foyerPrive);

        return $this->render('foyerprive/show.html.twig', array(
            'foyerPrive' => $foyerPrive,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing foyerPrive entity.
     *
     */
    public function editAction(Request $request, FoyerPrive $foyerPrive)
    {
        $deleteForm = $this->createDeleteForm($foyerPrive);
        $editForm = $this->createForm('AdminBundle\Form\FoyerPriveType', $foyerPrive);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('foyerprive_edit', array('id' => $foyerPrive->getId()));
        }

        return $this->render('foyerprive/edit.html.twig', array(
            'foyerPrive' => $foyerPrive,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a foyerPrive entity.
     *
     */
    public function deleteAction(Request $request, FoyerPrive $foyerPrive)
    {
        $form = $this->createDeleteForm($foyerPrive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($foyerPrive);
            $em->flush($foyerPrive);
        }

        return $this->redirectToRoute('foyerprive_index');
    }

    /**
     * Creates a form to delete a foyerPrive entity.
     *
     * @param FoyerPrive $foyerPrive The foyerPrive entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FoyerPrive $foyerPrive)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('foyerprive_delete', array('id' => $foyerPrive->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
