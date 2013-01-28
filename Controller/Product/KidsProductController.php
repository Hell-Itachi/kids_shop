<?php

namespace Itc\KidsBundle\Controller\Product;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\AdminBundle\Controller\Product\ProductController;

class KidsProductController extends ProductController
{
    /**
     *
     * @Route("/new/{parent_id}", name="product_new",
     * requirements={"parent_id" = "\d+"}, defaults={ "parent_id" = null})
     * @Template()
     */
    public function newAction($parent_id)
    {
        $em = $this->getDoctrine()->getManager();
        $entitys = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProductGroup')->findAll();
        $parent = parent::newAction($parent_id);
        foreach ($entitys as $entity) {
           $parent["child"][$entity->getId()]= $entity->getParentId();
        }
        return  $parent;        
    }
    /**
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entitys = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProductGroup')->findAll();
        $parent = parent::editAction($id);
        foreach ($entitys as $entity) {
           $parent["child"][$entity->getId()]= $entity->getParentId();
        }
        return $parent;
    }
    
    /**
     * @Template()
     */
    public function showTemplateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('Itc\KidsBundle\Entity\Template\Template')->findAll();
        foreach ($entities as $entity) {
           $array[$entity->getId()]= $entity->getName();
        }
        print_r($array);
        $ListTemplate = $this->createForm(new \Itc\KidsBundle\Form\Template\TemplateListType(), NULL, 
               array('data' => $array));
        return array(
            'list_template' => $ListTemplate->createView(),
            'id' => $id
        );
    }

    /**
     *
     * @Route("/{id}/edittemplate", name="product_edit_template")
     * @Method("POST")
     * @Template("ItcKidsBundle:Product\KidsProduct:edit.html.twig")
     */
    public function edittemplateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
       
        var_dump($_POST['itc_kidsbundle_templatelist']);
        $entities = $em->getRepository('Itc\KidsBundle\Entity\Template\Template')->findAll();
        foreach ($entities as $entity) {
           $array[$entity->getId()]= $entity->getName();
        }
        $form = $this->createForm(new \Itc\KidsBundle\Form\Template\TemplateListType(), NULL, 
               array('data' => $array));
        $entity = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProduct')->find($id);
        $form->bindRequest($request);
        $data = $form->getData() ;
        return array(
            'list_template' => $form->createView(),
            'id' => $id
        );
    }
}

