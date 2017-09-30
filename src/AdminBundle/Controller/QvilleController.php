<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Qville;
use AdminBundle\Entity\QvilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Qville controller.
 *
 */
class QvilleController extends Controller
{
    /**
     * Lists all qville entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tag = array('ville' => 'tunis');

        $qvilles2 = $em->getRepository('AdminBundle:Qville')->findQQbyville($tag);
        $qvilles1 = $em->getRepository('AdminBundle:Qville')->findAll();




        //both arrays will be merged including duplicates
        $qvilles = array_merge($qvilles1, $qvilles2);
        //duplicate objects will be removed
        $qvilles = array_map("unserialize", array_unique(array_map("serialize", $qvilles)));
        //array is sorted on the bases of id
        sort($qvilles);

        return $this->render('qville/index.html.twig', array(
            'qvilles' => $qvilles,

        ));

    }

    /**
     * Creates a new qville entity.
     *
     */
    public function newAction(Request $request)
    {
        $qville = new Qville();
        $form = $this->createForm('AdminBundle\Form\QvilleType', $qville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($qville);
            $em->flush($qville);

            return $this->redirectToRoute('qville_show', array('id' => $qville->getId()));
        }

        return $this->render('qville/new.html.twig', array(
            'qville' => $qville,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a qville entity.
     *
     */
    public function showAction(Qville $qville)
    {
        $deleteForm = $this->createDeleteForm($qville);

        return $this->render('qville/show.html.twig', array(
            'qville' => $qville,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing qville entity.
     *
     */
    public function editAction(Request $request, Qville $qville)
    {
        $deleteForm = $this->createDeleteForm($qville);
        $editForm = $this->createForm('AdminBundle\Form\QvilleType', $qville);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('qville_edit', array('id' => $qville->getId()));
        }

        return $this->render('qville/edit.html.twig', array(
            'qville' => $qville,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a qville entity.
     *
     */
    public function deleteAction(Request $request, Qville $qville)
    {
        $form = $this->createDeleteForm($qville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($qville);
            $em->flush($qville);
        }

        return $this->redirectToRoute('qville_index');
    }

    /**
     * Creates a form to delete a qville entity.
     *
     * @param Qville $qville The qville entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Qville $qville)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('qville_delete', array('id' => $qville->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
