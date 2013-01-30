<?php

namespace Itc\KidsBundle\Controller\Shipping;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Shipping\ShippingMethod;
use Itc\KidsBundle\Form\Shipping\ShippingMethodType;
use Itc\KidsBundle\Form\Shipping\ShippingMethodImageType;

/**
 * Shipping\ShippingMethod controller.
 *
 * @Route("/shipping")
 */
class ShippingMethodController extends Controller
{
    /**
     * Lists all Shipping\ShippingMethod entities.
     *
     * @Route("/", name="shipping")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:Shipping\ShippingMethod')->findAll();

        return array(
            'entities' => $entities,
        );
    }



    /**
     * Displays a form to create a new Shipping\ShippingMethod entity.
     *
     * @Route("/new", name="shipping_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ShippingMethod();
        $form   = $this->createForm(new ShippingMethodType(), $entity,
                    array("attr" => array("new" => true)));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Shipping\ShippingMethod entity.
     *
     * @Route("/create", name="shipping_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Shipping\ShippingMethod:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ShippingMethod();
        $form = $this->createForm(new ShippingMethodType(), $entity,
                    array("attr" => array("new" => true)) );
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shipping_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Shipping\ShippingMethod entity.
     *
     * @Route("/{id}/edit", name="shipping_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Shipping\ShippingMethod')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shipping\ShippingMethod entity.');
        }

        $editForm = $this->createForm(new ShippingMethodType(), $entity, 
                        array("attr" => array("new" => false)));
        $deleteForm = $this->createDeleteForm($id);
        $imageForm  = $this->createForm( new ShippingMethodImageType(), $entity);
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'image_form' =>   $imageForm->createView(),
        );
    }

    /**
     * Edits an existing Shipping\ShippingMethod entity.
     *
     * @Route("/{id}/update", name="shipping_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Shipping\ShippingMethod:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Shipping\ShippingMethod')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Shipping\ShippingMethod entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ShippingMethodType(), $entity, 
                        array("attr" => array("new" => false)));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('shipping_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Shipping\ShippingMethod entity.
     *
     * @Route("/{id}/delete", name="shipping_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Shipping\ShippingMethod')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Shipping\ShippingMethod entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('shipping'));
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
     * @Route("/{id}/shipping_update_image.{_format}", name="shipping_update_image",
     * defaults={"_format" = "json"})
     * @Method("POST")
     * @Template()
     */
    public function updateImageAction(Request $request, $id)
    {
        //если файлик не сейвится надо раздать права
        // на запись в папку куда он должен сейвицца!!!!!!!
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ItcKidsBundle:Shipping\ShippingMethod')->find( $id );
        $entity->setIcon("");
        $imageForm = $this->createForm( new ShippingMethodImageType(), $entity);
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
