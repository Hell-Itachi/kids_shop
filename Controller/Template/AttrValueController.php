<?php

namespace Itc\KidsBundle\Controller\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Template\AttrValue;
use Itc\KidsBundle\Form\Template\AttrValueType;

/**
 * Template\AttrValue controller.
 *
 * @Route("/attributsvalue")
 */
class AttrValueController extends Controller
{
    /**
     * Lists all Template\AttrValue entities.
     *
     * @Route("/", name="attributsvalue")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:Template\AttrValue')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Template\AttrValue entity.
     *
     * @Route("/{id}/{type}/{someid}/new", name="attributsvalue_new")
     * @Template()
     */
    public function newAction($id, $type ,$someid)
    {
        $entity = new AttrValue();
        $form   = $this->createForm(new AttrValueType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'attrid' => $id,
            'type'   => $type,
            'some'   => $someid
        );
    }

    /**
     * Creates a new Template\AttrValue entity.
     *
     * @Route("/{id}/{type}/{someid}/create", name="attributsvalue_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\AttrValue:new.html.twig")
     */
    public function createAction(Request $request, $id, $type ,$someid)
    {
        $em = $this->getDoctrine()->getManager();

        $attr = $em->getRepository('ItcKidsBundle:Template\Attr')->find($id);

        $entity  = new AttrValue();
        $entity->setAttr($attr);
        $name_type=$attr->getAttrtype()->getName();
        $form = $this->createForm(new AttrValueType(), $entity);
        $form->bind($request);

        if($name_type=='text'){
            $entity->setKod(1);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($type=='product'){
                $product = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProduct')->find($someid);
                $prod_attr  = new \Itc\KidsBundle\Entity\Template\KidsProductAttrvalue();
                $prod_attr->setProduct($product);
                $prod_attr->setAttrvalue($entity);
                $prod_attr->setIsVisible("1");
                $em->persist($prod_attr);
            }
            $em->persist($entity);
            $em->flush();
            $templid=$entity->getAttr()->getTemplId();
            if($type=='product'){$templid=$someid;}
            return $this->redirect($this->generateUrl($type.'_edit', array('id' => $templid)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Template\AttrValue entity.
     *
     * @Route("/{id}/edit", name="attributsvalue_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\AttrValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\AttrValue entity.');
        }

        $editForm = $this->createForm(new AttrValueType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Template\AttrValue entity.
     *
     * @Route("/{id}/inedit", name="attributsvalue_inedit")
     * @Template("ItcKidsBundle:Template\AttrValue:edit.html.twig")
     */
    public function ineditAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\AttrValue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\AttrValue entity.');
        }

        $editForm = $this->createForm(new AttrValueType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Template\AttrValue entity.
     *
     * @Route("/{id}/update", name="attributsvalue_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\AttrValue:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\AttrValue')->find($id);
        $templid=$entity->getAttr()->getTemplId();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\AttrValue entity.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AttrValueType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('template_edit', array('id' => $templid)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Template\AttrValue entity.
     *
     * @Route("/{id}/delete", name="attributsvalue_delete")
     */
    public function deleteAction($id)
    {
       
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Template\AttrValue')->find($id);
            $templid=$entity->getAttr()->getTemplId();
         
            $em->remove($entity);
            $em->flush();
        

        return $this->redirect($this->generateUrl('template_edit', array('id'=>$templid)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
