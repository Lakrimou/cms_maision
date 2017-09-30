<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Immobiliair;
use AdminBundle\Entity\Qouiqui;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Immobiliair controller.
 *
 */
class ModuleController extends Controller
{
    /**
     * Lists all immobiliair entities.
     *
     */
    public function indexAction($category ,$qq)
    {
        dump($category);die;

        $category = ucfirst($category);


        $em = $this->getDoctrine()->getManager();

        $QQ = $em->getRepository('AdminBundle:Qouiqui')->findOneById($qq);

        $cat = $em->getRepository('AdminBundle:'.$category)->findBy(array('qouiqui' => $QQ->getId()));

        dump($cat);

        return $this->render('AdminBundle:module:list.html.twig', array(
            'cat' => $cat,
            'category' => $category
        ));

    }

    /**
     * Creates a new immobiliair entity.
     *
     */
    public function newAction(Request $request)
    {
        $immobiliair = new Immobiliair();
        $form = $this->createForm('AdminBundle\Form\ImmobiliairType', $immobiliair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($immobiliair);
            $em->flush($immobiliair);

            return $this->redirectToRoute('immobiliair_show', array('id' => $immobiliair->getId()));
        }

        return $this->render('DashboardBundle//new.html.twig', array(
            'immobiliair' => $immobiliair,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a immobiliair entity.
     *
     */
    public function showAction(Immobiliair $immobiliair)
    {
        $deleteForm = $this->createDeleteForm($immobiliair);

        return $this->render('immobiliair/show.html.twig', array(
            'immobiliair' => $immobiliair,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing immobiliair entity.
     *
     */
    public function editAction(Request $request, Immobiliair $immobiliair)
    {
//        $deleteForm = $this->createDeleteForm($immobiliair);
        $editForm = $this->createForm('AdminBundle\Form\ImmobiliairType', $immobiliair);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('immobiliair_edit', array('id' => $immobiliair->getId()));
        }

        return $this->render('AdminBundle:module:Immobiliair\edit_immobiliaires.html.twig', array(
            'immobiliair' => $immobiliair,
            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a immobiliair entity.
     *
     */
    public function deleteAction(Request $request, Immobiliair $immobiliair)
    {
        $form = $this->createDeleteForm($immobiliair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($immobiliair);
            $em->flush($immobiliair);
        }

        return $this->redirectToRoute('immobiliair_index');
    }

    /**
     * Creates a form to delete a immobiliair entity.
     *
     * @param Immobiliair $immobiliair The immobiliair entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Immobiliair $immobiliair)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('immobiliair_delete', array('id' => $immobiliair->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
