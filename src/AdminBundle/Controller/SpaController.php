<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Spa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Spa controller.
 *
 */
class SpaController extends Controller
{
    /**
     * Lists all spa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $spas = $em->getRepository('AdminBundle:Spa')->findAll();

        return $this->render('spa/index.html.twig', array(
            'spas' => $spas,
        ));
    }

    /**
     * Creates a new spa entity.
     *
     */
    public function newAction(Request $request)
    {
        $spa = new Spa();
        $form = $this->createForm('AdminBundle\Form\SpaType', $spa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($spa);
            $em->flush($spa);

            return $this->redirectToRoute('spa_show', array('id' => $spa->getId()));
        }

        return $this->render('spa/new.html.twig', array(
            'spa' => $spa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a spa entity.
     *
     */
    public function showAction(Spa $spa)
    {
        $deleteForm = $this->createDeleteForm($spa);

        return $this->render('spa/show.html.twig', array(
            'spa' => $spa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing spa entity.
     *
     */
    public function editAction(Request $request, Spa $spa)
    {
        $deleteForm = $this->createDeleteForm($spa);
        $editForm = $this->createForm('AdminBundle\Form\SpaType', $spa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spa_edit', array('id' => $spa->getId()));
        }

        return $this->render('spa/edit.html.twig', array(
            'spa' => $spa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a spa entity.
     *
     */
    public function deleteAction(Request $request, Spa $spa)
    {
        $form = $this->createDeleteForm($spa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($spa);
            $em->flush($spa);
        }

        return $this->redirectToRoute('spa_index');
    }

    /**
     * Creates a form to delete a spa entity.
     *
     * @param Spa $spa The spa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Spa $spa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('spa_delete', array('id' => $spa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
