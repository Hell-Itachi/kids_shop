<?php

namespace Itc\KidsBundle\Controller\Product;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\AdminBundle\Controller\Product\ProductController;
use Itc\KidsBundle\Entity\Template\KidsProductAttrvalue;
use Itc\KidsBundle\Entity\Template\Attr;

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
        return parent::newAction($parent_id);
//        $em = $this->getDoctrine()->getManager();
//        $entitys = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProductGroup')->findAll();
//        $parent = parent::newAction($parent_id);
//        foreach ($entitys as $entity) {
//           $parent["child"][$entity->getId()]= $entity->getParentId();
//        }
//        return  $parent;        
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
        $temples = $em->getRepository('Itc\KidsBundle\Entity\Template\Template')->findBy(array("is_default" => 0));
        $array="";
        foreach ($temples as $entity) {
           $array[$entity->getId()]= $entity->getName();
        }
        $ListTemplate = $this->createForm(new \Itc\KidsBundle\Form\Template\TemplateListType(), NULL, 
               array('data' => $array));
        $product = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProduct')->find($id);
        $product_values=$product->getAttrvalues();
        
        $templid="";
        $editForm="";
        $deleteForm="";
        $checked="";
        $mainid="";
        $entities="";
        if(is_object($product_values[0]) && $product_values!=""){
            
            $templid=$product_values[0]->getAttrvalue()->getAttr()->getTemplId();
            foreach ($product_values as $val) {
                $checked[$val->getAttrvalue()->getId()]=$val->getIsVisible();
                $mainid[$val->getAttrvalue()->getId()]=$val->getId();
            }
            
             $entities = $em->getRepository('ItcKidsBundle:Template\Attr')
                                ->createQueryBuilder('A')
                                ->select('A')
                                ->innerJoin('A.attrvalues', 'V')
                                ->innerJoin('V.productattrvalues','P')
                                ->where("P.product = :id")
                                ->setParameter('id', $product)
                                ->orderBy('A.kod', 'ASC')
                                ->getQuery()->execute();
    
        foreach ($entities as $entity){
                       $editForm[$entity->getId()] = $this->createAttributesForm($entity, $product)->createView();
                                   $deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())
                            ->createView();
            }  
        }
        $createChangeCheckForm = 
                    $this->createChangeCheckForm()
                            ->createView();
        $prod_atrr = new \Itc\KidsBundle\Entity\Template\Attr();
        $form_new_prod_attr = $this->createForm(new \Itc\KidsBundle\Form\Template\AttrType("appendedDropdownButton"), $prod_atrr,
                     array("attr" => array("new" => true, "class"=>"appendedDropdownButton")));
        return array(
            'list_template' => $ListTemplate->createView(),
            'id' => $id,
            'entities' => $entities,
            'templid'=> $templid, 
            'edit_form'=>$editForm,
            'check_form'=>$createChangeCheckForm,
            'checkeds'=>$checked,
            'mainid'=>$mainid,
            'delete_form'=>$deleteForm,
            'form_add_prod_tov'=>$form_new_prod_attr->createView()
        );
    }
private function createAttributesForm( $entity, $product ){
        
        $default=$entity->getTempl()->getIsDefault();
        
       if($entity->getAttrtype()->getName()=='text'){
           $attr=$entity->getAttrvalues();
           foreach($attr as $val){
           $attr = $val;
           }
            $em = $this->getDoctrine()->getManager();
            $attr_prod = $em->getRepository('Itc\KidsBundle\Entity\Template\KidsProductAttrvalue')->findBy(array("product"=>$product, "attrvalue"=>$attr));
            foreach ($attr_prod as $value) {
                $attr_prod=$value;
            }
            return  $this->createFormBuilder(
                    array('name' => $entity->getName(), "attrtype"=>"", 
                        "attrvalues"=>$attr_prod->getValue(), 'default'=>$default, 'lists'=>0))
                    ->add('name')
                    ->add('default', 'hidden')
                    ->add('lists', 'hidden')
                    ->add('attrtype', 'choice', array('choices' => array($entity->getAttrtype()->getName())))
                    ->add('attrvalues')
                    ->getForm();
       }
       else{
                    $em = $this->getDoctrine()->getManager();
                    $qb= $em->getRepository('ItcKidsBundle:Template\AttrValue')
                                ->createQueryBuilder('A')
                                ->select('A')
                                ->where('A.attr=:attr')
                                ->setParameter('attr', $entity);
            return  $this->createFormBuilder(
                    array('name' => $entity->getName(), "attrtype"=>"", "attrvalues"=>array($entity->getAttrvalues()), 'default'=>$default, 'lists'=>1))
                    ->add('name')
                    ->add('default', 'hidden')
                    ->add('lists', 'hidden')
                    ->add('attrtype', 'choice', array('choices' => array($entity->getAttrtype()->getName())))
                    ->add('attrvalues', 'entity', array(
                        'class' => 'ItcKidsBundle:Template\AttrValue',
                        'expanded' => true,
                        'query_builder' => $qb,
                           ))
                    ->getForm();
       }
        
    }
   private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    private function createChangeCheckForm( ){

       return  $this->createFormBuilder(
                    array('id_atr' => "", "prod_id"=>""))
                    ->add( 'id_atr', 'hidden', array('attr' => array('class'=>'chekidattr')) )
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
        return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
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
        $em = $this->getDoctrine()->getManager();
        $productval = $em->getRepository('Itc\KidsBundle\Entity\Template\KidsProductAttrvalue')->find($attrid['id_atr']);
        if($productval->getIsVisible()==1){
        $productval->setIsVisible("0");}
        else{$productval->setIsVisible("1");}
        $em->persist($productval);
                    $em->flush();
        return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
    }
        /**
     *
     * @Route("/{id}/{prodid}/deleteattrprod", name="attributs_for_prod_update")
     * @Method("POST")
     * @Template()
     */
    public function AttrForUpdateprodAction(Request $request, $id, $prodid)
    {
        $form=$request->request->get('form');
        $em = $this->getDoctrine()->getManager();
        $attr = $em->getRepository('Itc\KidsBundle\Entity\Template\Attr')->find($id);
        $attr_val=$attr->getAttrvalues();
        foreach ($attr_val as $value) {
                $attr_prod=$value;
            }
        $product = $em->getRepository('Itc\KidsBundle\Entity\Product\KidsProduct')->find($prodid);
        $productval = $em->getRepository('Itc\KidsBundle\Entity\Template\KidsProductAttrvalue')
                                ->createQueryBuilder('A')
                                ->select('A')
                                ->where("A.product =:id")
                                ->setParameter('id', $product)
                                ->andWhere("A.attrvalue =:attr")
                                ->setParameter('attr', $attr_prod)
                                ->getQuery()->getOneorNullResult();
        $productval->setValue($form['attrvalues']);
        $em->persist($productval);
                    $em->flush();
        return $this->redirect($this->generateUrl('product_edit', array('id' => $prodid)));
    }
}

