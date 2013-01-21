<?php

namespace Itc\KidsBundle\Controller\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Form\Template\TemplateType;

/**
 * Template\Template controller.
 *
 * @Route("/template")
 */
class TemplateController extends Controller
{
    /**
     * Lists all Template\Template entities.
     *
     * @Route("/", name="template")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:Template\Template')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Template\Template entity.
     *
     * @Route("/new", name="template_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new \Itc\KidsBundle\Entity\Template\Template();
        $form   = $this->createForm(new TemplateType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Template\Template entity.
     *
     * @Route("/create", name="template_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\Template:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new \Itc\KidsBundle\Entity\Template\Template();
        $form = $this->createForm(new TemplateType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('template_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Template\Template entity.
     *
     * @Route("/{id}/edit", name="template_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\Template')->find($id);
        $entities = $em->getRepository('ItcKidsBundle:Template\Template')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\Template entity.');
        }

        $editForm = $this->createForm(new TemplateType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        foreach ($entities as $form) {
            $deleteTempForm[$form->getId()] = $this->createDeleteForm($form->getId())
                            ->createView();
        }
        return array(
            'entity'      => $entity,
            'entities'    => $entities,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'delete_template_form' =>$deleteTempForm       
        );
    }

    /**
     * Edits an existing Template\Template entity.
     *
     * @Route("/{id}/update", name="template_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\Template:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\Template')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\Template entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TemplateType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('template_edit', array('id' => $id)));
        }
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Template\Template entity.
     *
     * @Route("/{id}/delete", name="template_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Template\Template')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Template\Template entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('template'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
