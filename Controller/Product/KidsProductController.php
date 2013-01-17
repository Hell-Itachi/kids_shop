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

}

