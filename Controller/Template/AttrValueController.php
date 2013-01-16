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
     * @Route("/{id}/new", name="attributsvalue_new")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new AttrValue();
        $form   = $this->createForm(new AttrValueType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'attrid' => $id
        );
    }

    /**
     * Creates a new Template\AttrValue entity.
     *
     * @Route("/{id}/create", name="attributsvalue_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\AttrValue:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $attr = $em->getRepository('ItcKidsBundle:Template\Attr')->find($id);

        $entity  = new AttrValue();
        $entity->setAttr($attr);
        
        $form = $this->createForm(new AttrValueType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('attributsvalue_edit', array('id' => $entity->getId())));
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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\AttrValue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AttrValueType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('attributsvalue_edit', array('id' => $id)));
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
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Template\AttrValue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Template\AttrValue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('attributsvalue'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
