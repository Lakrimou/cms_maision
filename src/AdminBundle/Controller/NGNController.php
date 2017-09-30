<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Ngn;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ngn controller.
 *
 */
class NGNController extends Controller
{
    /**
     * Lists all nGN entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $nGNs = $em->getRepository('AdminBundle:Ngn')->findAll();


        return $this->render('ngn/index.html.twig', array(
            'nGNs' => $nGNs,
        ));


    }

    /**
     * Creates a new nGN entity.
     *
     */
    public function newAction(Request $request)
    {
        $nGN = new Ngn();
        $form = $this->createForm('AdminBundle\Form\NGNType', $nGN);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nGN);
            $em->flush($nGN);

            return $this->redirectToRoute('ngn_show', array('id' => $nGN->getId()));
        }

        return $this->render('ngn/new.html.twig', array(
            'nGN' => $nGN,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a nGN entity.
     *
     */
    public function showAction(Ngn $nGN)
    {
        $deleteForm = $this->createDeleteForm($nGN);

        return $this->render('ngn/show.html.twig', array(
            'nGN' => $nGN,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nGN entity.
     *
     */
    public function editAction(Request $request, Ngn $nGN)
    {
        $deleteForm = $this->createDeleteForm($nGN);
        $editForm = $this->createForm('AdminBundle\Form\NGNType', $nGN);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ngn_edit', array('id' => $nGN->getId()));
        }

        return $this->render('ngn/edit.html.twig', array(
            'nGN' => $nGN,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a nGN entity.
     *
     */
    public function deleteAction(Request $request, Ngn $nGN)
    {
        $form = $this->createDeleteForm($nGN);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nGN);
            $em->flush($nGN);
        }

        return $this->redirectToRoute('ngn_index');
    }

    /**
     * Creates a form to delete a nGN entity.
     *
     * @param Ngn $nGN The nGN entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ngn $nGN)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ngn_delete', array('id' => $nGN->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
