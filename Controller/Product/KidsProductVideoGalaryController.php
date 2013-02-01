<?php

namespace Itc\KidsBundle\Controller\Product;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Product\KidsProductVideoGalary;
use Itc\KidsBundle\Form\Product\KidsProductVideoGalaryType;

/**
 * Product\KidsProductVideoGalary controller.
 *
 * @Route("/videogallery")
 */
class KidsProductVideoGalaryController extends Controller
{
    /**
     * Lists all Product\KidsProductVideoGalary entities.
     *
     * @Route("/", name="videogallery")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Product\KidsProductVideoGalary entity.
     *
     * @Route("/{id}/show", name="videogallery_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product\KidsProductVideoGalary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Product\KidsProductVideoGalary entity.
     *
     * @Route("/{product_id}/new", name="videogallery_new")
     * @Template()
     */
    public function newAction($product_id)
    {
        $em = $this->getDoctrine()->getManager();
        $gallary=$em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->findByProductId($product_id);
        
        foreach($gallary as $gal)
        {
            if($gal->getId()!=""){
                return $this->redirect($this->generateUrl('videogallery_edit', array('id' => $gal->getId(), 'product_id'=>$product_id)));
            }
                
        }
        $entity = new KidsProductVideoGalary();
        $form   = $this->createForm(new KidsProductVideoGalaryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'product_id' =>$product_id
        );
    }

    /**
     * Creates a new Product\KidsProductVideoGalary entity.
     *
     * @Route("/{product_id}/create", name="videogallery_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Product\KidsProductVideoGalary:new.html.twig")
     */
    public function createAction(Request $request, $product_id)
    {
        $entity  = new KidsProductVideoGalary();
        $form = $this->createForm(new KidsProductVideoGalaryType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('ItcKidsBundle:Product\KidsProduct')->find($product_id);
            $entity->setProduct($product);
            $entity->setProductId($product->getId());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('videogallery_edit', array('id' => $entity->getId(), 'product_id'=>$product_id)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'product_id'  => $product_id
        );
    }

    /**
     * Displays a form to edit an existing Product\KidsProductVideoGalary entity.
     *
     * @Route("/{id}/{product_id}/edit", name="videogallery_edit")
     * @Template()
     */
    public function editAction($id, $product_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product\KidsProductVideoGalary entity.');
        }

        $editForm = $this->createForm(new KidsProductVideoGalaryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'product_id'  => $product_id
        );
    }

    /**
     * Edits an existing Product\KidsProductVideoGalary entity.
     *
     * @Route("/{id}/{product_id}/update", name="videogallery_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Product\KidsProductVideoGalary:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $product_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product\KidsProductVideoGalary entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new KidsProductVideoGalaryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('videogallery_edit', array('id' => $id, 'product_id'=>$product_id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'product_id'  => $product_id
        );
    }

    /**
     * Deletes a Product\KidsProductVideoGalary entity.
     *
     * @Route("/{id}/{product_id}/delete", name="videogallery_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id, $product_id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product\KidsProductVideoGalary entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product_edit',array('id'=>$product_id)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
