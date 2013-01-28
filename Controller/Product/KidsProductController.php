<?php

namespace Itc\KidsBundle\Controller\Product;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\AdminBundle\Controller\Product\ProductController;
use Itc\KidsBundle\Entity\Template\KidsProductAttrvalue;

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
        $array="";
        foreach ($entities as $entity) {
           $array[$entity->getId()]= $entity->getName();
        }
        $ListTemplate = $this->createForm(new \Itc\KidsBundle\Form\Template\TemplateListType(), NULL, 
               array('data' => $array));
        $product = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProduct')->find($id);
        $product_values=$product->getAttrvalues();
        
        $templid="";
        $editForm="";
        if(is_object($product_values)){
            $ids="";
            $checked="";
            $mainid="";
            foreach ($product_values as $val) {
                $templid=$val->getAttrvalue()->getAttr()->getTemplId();
                $ids[]=$val->getAttrvalue()->getAttr()->getId();
                $checked[$val->getAttrvalue()->getId()]=$val->getIsVisible();
                $mainid[$val->getAttrvalue()->getId()]=$val->getId();
            }
            
             $entities = $em->getRepository('ItcKidsBundle:Template\Attr')->findBy(
                array('id' => $ids), array('kod'=>'ASC'));
       
        $editForm="";
        foreach ($entities as $entity){
            $editForm[$entity->getId()] = $this->createForm(new \Itc\KidsBundle\Form\Template\AttrType($entity->getAttrtype()->getName()), $entity,
                     array("attr" => array("new" => true, "class"=>$entity->getAttrtype()->getName())))->createView();
         
            }  
        }
        $createChangeCheckForm = 
                    $this->createChangeCheckForm()
                            ->createView();
        return array(
            'list_template' => $ListTemplate->createView(),
            'id' => $id,
            'entities' => $entities,
            'templid'=> $templid, 
            'edit_form'=>$editForm,
            'check_form'=>$createChangeCheckForm,
            'checkeds'=>$checked,
            'mainid'=>$mainid
        );
    }
    private function createChangeCheckForm( ){

       return  $this->createFormBuilder(
                    array('id' => "", "prod_id"=>""))
                    ->add( 'id', 'hidden', array('attr' => array('class'=>'chekidattr')) )
                    ->add('prod_id', 'hidden',array('attr' => array('class'=>'chekidprod')) )
                    ->getForm();
    }
    /**
     *
     * @Route("/{id}/edittemplate", name="product_edit_template")
     * @Method("POST")
     * @Template()
     */
    public function edittemplateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProduct')->find($id);
        $product_values=$product->getAttrvalues();
        if(is_object($product_values)){
            foreach ($product_values as $val) {
                
            $em->remove($val);
           }
          }
        $entities = $em->getRepository('Itc\KidsBundle\Entity\Template\Template')->findAll();
        foreach ($entities as $entity) {
           $array[$entity->getId()]= $entity->getName();
        }
        $form = $this->createForm(new \Itc\KidsBundle\Form\Template\TemplateListType(), NULL, 
               array('data' => $array));
     
        $form->bindRequest($request);
        $data = $form->getData() ;
        $templid=$data['name'];
        $template= $em->getRepository('Itc\KidsBundle\Entity\Template\Template')->find($templid);
        $atributes=$template->getAttributes();
        foreach ($atributes as $v) {
           $values= $v->getAttrvalues();
           $type=$v->getAttrtype()->getName();
           foreach ($values as $attrval) {
                  $prod_attr  = new KidsProductAttrvalue();
                  $prod_attr->setProduct($product);
                  $prod_attr->setAttrvalue($attrval);
                  $prod_attr->setIsVisible("1");
                  if($type=='text'){
                      $prod_attr->setValue($attrval->getValue());
                  }
                  $em = $this->getDoctrine()->getManager();
                    $em->persist($prod_attr);
                    $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('product_edit', array('id' => $entity->getId())));
    }
    /**
     *
     * @Route("/{id}/deleteattrprod", name="delete_attr_prod")
     * @Method("POST")
     * @Template()
     */
    public function DeleteattrprodAction(Request $request, $id)
    {
        $attrid=$request->request->get('form');
        print_r($attrid['id']);
        $em = $this->getDoctrine()->getManager();
        $productval = $em->getRepository('Itc\KidsBundle\Entity\Template\KidsProductAttrvalue')->find($attrid['id']);
        if($productval->getIsVisible()==1){
        $productval->setIsVisible("0");}
        else{$productval->setIsVisible("1");}
        $em->persist($productval);
                    $em->flush();
        return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
    }
}

