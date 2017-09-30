<?php

namespace DashboardBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\Qouiqui;
use AdminBundle\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Car controller.
 *
 */
class CarController extends Controller
{
    /**
     * Lists all car entities.
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('AdminBundle:Car')->findAll();

        return $this->render('DashboardBundle:car:index.html.twig', array(
            'cars' => $cars,
        ));

    }

    /**
     * Creates a new car entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        $qq=new Qouiqui();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $user));
        $car = new Car();
        $ext='.jpg';
        $imageNom=uniqid() . $ext;
        $form = $this->createForm('DashboardBundle\Form\CarType', $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $carQ=new Car();
            $car->setQouiqui($qq);

            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush($car);
            $em->refresh($car);
            $car2=$car->getId();
            $directory=$_SERVER['PHP_DOCUMENT_ROOT'] . '/web/annuaire/web/uploads/car/' . $car2 . '/';
            if(isset($_FILES)){

            if(!is_dir($directory)){
                mkdir($directory, 0777);
                $file=$_FILES['adminbundle_car']['tmp_name']['images'];
                dump(pathinfo($file));
                dump($file, sizeof($file));
                $fileUpload=$directory . $imageNom;
                dump($fileUpload);
                move_uploaded_file($file, $fileUpload);
            }
            else{
                die('erreur!');
            }
            }
            $car->setImages($imageNom);
            $em->flush($car);
            die;

            return $this->redirectToRoute('dashboard_car_afficher', array('id' => $car->getId()));
        }

        return $this->render('DashboardBundle:car:new.html.twig', array(
            'car' => $car,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a car entity.
     *
     */
    public function showAction(Car $car, $id)
    {
        $user = $this->getUser();
        $qq = new Qouiqui();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $user));
        $car = new Car();
        $car = $this->getDoctrine()->getRepository('AdminBundle:Car')
            ->findOneBy(array('qouiqui' => $qq, 'id' => $id));
        if ($car) {

            $deleteForm = $this->createDeleteForm($car);
            return $this->render('DashboardBundle:car:show.html.twig', array(
                'car' => $car,
                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            die('vous ne peut pas accéder a cette produit!');
        }
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     */
    public function editAction(Request $request, Car $car, $id)
    {

        $user = $this->getUser();
        $qq = new Qouiqui();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $user));
        $car1 = new Car();
        $car1 = $this->getDoctrine()->getRepository('AdminBundle:Car')
            ->findOneBy(array('qouiqui' => $qq->getId(), 'id' => $id));

        $deleteForm = $this->createDeleteForm($car);
        $editForm = $this->createForm('DashboardBundle\Form\CarType', $car);

        $editForm->handleRequest($request);
        if ($car1) {

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('dashboard_car_edit', array('id' => $car->getId()));
            }

            return $this->render('DashboardBundle:car:edit.html.twig', array(
                'quoiqui' => $qq,
                'car' => $car,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            die('vous ne peut pas accéder a cette produit!');
        }
    }

    /**
     * Deletes a car entity.
     *
     */
    public function deleteAction(Request $request, Car $car, $id)
    {
        $user = $this->getUser();
        $qq = new Qouiqui();
        $qq = $this->getDoctrine()->getRepository('AdminBundle:Qouiqui')
            ->findOneBy(array('id' => $user));
        $car1 = new Car();
        $car1 = $this->getDoctrine()->getRepository('AdminBundle:Car')
            ->findOneBy(array('qouiqui' => $qq->getId(), 'id' => $id));
        if ($car1) {

            $form = $this->createDeleteForm($car);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($car);
                $em->flush($car);
            }

            return $this->redirectToRoute('dashboard_car_liste',array('id'=>$qq->getId()));
        }
        else {
            die('vous ne peut pas accéder a cette produit!');
        }
    }

    /**
     * Creates a form to delete a car entity.
     *
     * @param Car $car The car entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Car $car)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dashboard_car_supprimer', array('id' => $car->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
