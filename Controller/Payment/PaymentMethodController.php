<?php

namespace Itc\KidsBundle\Controller\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Payment\PaymentMethod;
use Itc\KidsBundle\Form\Payment\PaymentMethodType;
use Itc\KidsBundle\Form\Payment\PaymentMethodImageType;

/**
 * Payment\PaymentMethod controller.
 *
 * @Route("/pay_meth")
 */
class PaymentMethodController extends Controller
{
    /**
     * Lists all Payment\PaymentMethod entities.
     *
     * @Route("/", name="pay_meth")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:Payment\PaymentMethod')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Payment\PaymentMethod entity.
     *
     * @Route("/{id}/show", name="pay_meth_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Payment\PaymentMethod')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Payment\PaymentMethod entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Payment\PaymentMethod entity.
     *
     * @Route("/new", name="pay_meth_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PaymentMethod();
        $form   = $this->createForm(new PaymentMethodType(), $entity,
                    array("attr" => array("new" => true)));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Payment\PaymentMethod entity.
     *
     * @Route("/create", name="pay_meth_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Payment\PaymentMethod:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new PaymentMethod();
        $form = $this->createForm(new PaymentMethodType(), $entity,
                    array("attr" => array("new" => true)) );
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pay_meth_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Payment\PaymentMethod entity.
     *
     * @Route("/{id}/edit", name="pay_meth_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Payment\PaymentMethod')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Payment\PaymentMethod entity.');
        }

        $editForm = $this->createForm(new PaymentMethodType(), $entity, 
                        array("attr" => array("new" => false)));
        $deleteForm = $this->createDeleteForm($id);
        $imageForm  = $this->createForm( new PaymentMethodImageType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'image_form' =>   $imageForm->createView(),
        );
    }

    /**
     * Edits an existing Payment\PaymentMethod entity.
     *
     * @Route("/{id}/update", name="pay_meth_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Payment\PaymentMethod:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Payment\PaymentMethod')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Payment\PaymentMethod entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PaymentMethodType(), $entity, 
                        array("attr" => array("new" => false)));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pay_meth_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Payment\PaymentMethod entity.
     *
     * @Route("/{id}/delete", name="pay_meth_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Payment\PaymentMethod')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Payment\PaymentMethod entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pay_meth'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
        /**
     * Edits an existing Shipping entity.
     *
     * @Route("/{id}/pay_meth_update_image.{_format}", name="pay_meth_update_image",
     * defaults={"_format" = "json"})
     * @Method("POST")
     * @Template()
     */
    public function updateImageAction(Request $request, $id)
    {
        //если файлик не сейвится надо раздать права
        // на запись в папку куда он должен сейвицца!!!!!!!
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ItcKidsBundle:Payment\PaymentMethod')->find( $id );
        $entity->setIcon("");
        $imageForm = $this->createForm( new PaymentMethodImageType(), $entity);
        $imageForm->bind( $request );
        $imageForm['iconImage']->getData()->getClientOriginalName();
        if ( $imageForm->isValid() ) {
            $em->flush();
        }
        return array(
            'entity' => $entity,
        );
    }
}
