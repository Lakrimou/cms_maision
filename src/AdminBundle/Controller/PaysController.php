<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Pays;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pay controller.
 *
 */
class PaysController extends Controller {

    /**
     * Lists all pay entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('AdminBundle:Pays')->findAll();

        return $this->render('pays/index.html.twig', array(
                    'pays' => $pays,
        ));
    }

    /**
     * Creates a new pay entity.
     *
     */
    public function newAction(Request $request) {
        $pay = new Pays();
        $form = $this->createForm('AdminBundle\Form\PaysType', $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pay);
            $em->flush($pay);

            return $this->redirectToRoute('pays_show', array('id' => $pay->getId()));
        }

        return $this->render('pays/new.html.twig', array(
                    'pay' => $pay,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pay entity.
     *
     */
    public function showAction(Pays $pay) {
        $deleteForm = $this->createDeleteForm($pay);

        return $this->render('pays/show.html.twig', array(
                    'pay' => $pay,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pay entity.
     *
     */
    public function editAction(Request $request, Pays $pay) {
        $deleteForm = $this->createDeleteForm($pay);
        $editForm = $this->createForm('AdminBundle\Form\PaysType', $pay);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pays_edit', array('id' => $pay->getId()));
        }

        return $this->render('pays/edit.html.twig', array(
                    'pay' => $pay,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pay entity.
     *
     */
    public function deleteAction(Request $request, Pays $pay) {
        $form = $this->createDeleteForm($pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pay);
            $em->flush($pay);
        }

        return $this->redirectToRoute('pays_index');
    }

    /**
     * Creates a form to delete a pay entity.
     *
     * @param Pays $pay The pay entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pays $pay) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('pays_delete', array('id' => $pay->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    

}
