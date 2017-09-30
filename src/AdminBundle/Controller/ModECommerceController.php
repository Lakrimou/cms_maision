<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\ModECommerce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Modecommerce controller.
 *
 */
class ModECommerceController extends Controller
{
    /**
     * Lists all modECommerce entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modECommerces = $em->getRepository('AdminBundle:ModECommerce')->findAll();

        return $this->render('modecommerce/index.html.twig', array(
            'modECommerces' => $modECommerces,
        ));
    }

    /**
     * Creates a new modECommerce entity.
     *
     */
    public function newAction(Request $request)
    {
        $modECommerce = new Modecommerce();
        $form = $this->createForm('AdminBundle\Form\ModECommerceType', $modECommerce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modECommerce);
            $em->flush();

            return $this->redirectToRoute('modecommerce_show', array('id' => $modECommerce->getId()));
        }

        return $this->render('modecommerce/new.html.twig', array(
            'modECommerce' => $modECommerce,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a modECommerce entity.
     *
     */
    public function showAction(ModECommerce $modECommerce)
    {
        $deleteForm = $this->createDeleteForm($modECommerce);

        return $this->render('modecommerce/show.html.twig', array(
            'modECommerce' => $modECommerce,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing modECommerce entity.
     *
     */
    public function editAction(Request $request, ModECommerce $modECommerce)
    {
        $deleteForm = $this->createDeleteForm($modECommerce);
        $editForm = $this->createForm('AdminBundle\Form\ModECommerceType', $modECommerce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('modecommerce_edit', array('id' => $modECommerce->getId()));
        }

        return $this->render('modecommerce/edit.html.twig', array(
            'modECommerce' => $modECommerce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a modECommerce entity.
     *
     */
    public function deleteAction(Request $request, ModECommerce $modECommerce)
    {
        $form = $this->createDeleteForm($modECommerce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($modECommerce);
            $em->flush();
        }

        return $this->redirectToRoute('modecommerce_index');
    }

    /**
     * Creates a form to delete a modECommerce entity.
     *
     * @param ModECommerce $modECommerce The modECommerce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ModECommerce $modECommerce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('modecommerce_delete', array('id' => $modECommerce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
