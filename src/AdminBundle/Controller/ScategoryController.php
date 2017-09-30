<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Scategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Scategory controller.
 *
 */
class ScategoryController extends Controller
{
    /**
     * Lists all scategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scategories = $em->getRepository('AdminBundle:Scategory')->findAll();

        return $this->render('scategory/index.html.twig', array(
            'scategories' => $scategories,
        ));
    }

    /**
     * Creates a new scategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $scategory = new Scategory();
        $form = $this->createForm('AdminBundle\Form\ScategoryType', $scategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scategory);
            $em->flush($scategory);

            return $this->redirectToRoute('scategory_show', array('id' => $scategory->getId()));
        }

        return $this->render('scategory/new.html.twig', array(
            'scategory' => $scategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a scategory entity.
     *
     */
    public function showAction(Scategory $scategory)
    {
        $deleteForm = $this->createDeleteForm($scategory);

        return $this->render('scategory/show.html.twig', array(
            'scategory' => $scategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing scategory entity.
     *
     */
    public function editAction(Request $request, Scategory $scategory)
    {
        $deleteForm = $this->createDeleteForm($scategory);
        $editForm = $this->createForm('AdminBundle\Form\ScategoryType', $scategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scategory_edit', array('id' => $scategory->getId()));
        }

        return $this->render('scategory/edit.html.twig', array(
            'scategory' => $scategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a scategory entity.
     *
     */
    public function deleteAction(Request $request, Scategory $scategory)
    {
        $form = $this->createDeleteForm($scategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scategory);
            $em->flush($scategory);
        }

        return $this->redirectToRoute('scategory_index');
    }

    /**
     * Creates a form to delete a scategory entity.
     *
     * @param Scategory $scategory The scategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Scategory $scategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('scategory_delete', array('id' => $scategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
