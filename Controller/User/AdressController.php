<?php

namespace Itc\KidsBundle\Controller\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\User\Adress;
use Itc\KidsBundle\Form\User\AdressType;

/**
 * User\Adress controller.
 *
 * @Route("/user_addr")
 */
class AdressController extends Controller
{
    /**
     * Lists all User\Adress entities.
     *
     * @Route("/", name="user_addr")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:User\Adress')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a User\Adress entity.
     *
     * @Route("/{id}/show", name="user_addr_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:User\Adress')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User\Adress entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new User\Adress entity.
     *
     * @Route("/new", name="user_addr_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Adress();
        $form   = $this->createForm(new AdressType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new User\Adress entity.
     *
     * @Route("/create", name="user_addr_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:User\Adress:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Adress();
        $form = $this->createForm(new AdressType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_addr_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User\Adress entity.
     *
     * @Route("/{id}/edit", name="user_addr_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:User\Adress')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User\Adress entity.');
        }

        $editForm = $this->createForm(new AdressType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User\Adress entity.
     *
     * @Route("/{id}/update", name="user_addr_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:User\Adress:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:User\Adress')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User\Adress entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AdressType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_addr_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User\Adress entity.
     *
     * @Route("/{id}/delete", name="user_addr_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:User\Adress')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User\Adress entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_addr'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
