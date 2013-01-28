<?php

namespace Itc\KidsBundle\Controller\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Template\Attr;
use Itc\KidsBundle\Form\Template\AttrType;

/**
 * Template\Attr controller.
 *
 * @Route("/attributs")
 */
class AttrController extends Controller
{
    /**
     * Lists all Template\Attr entities.
     *
     * @Route("/{templid}", name="attributs")
     * @Template()
     */
    public function indexAction($templid)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ItcKidsBundle:Template\Attr')->findBy(
                array('templ_id' => $templid), array('kod'=>'ASC'));
       
        $editForm="";
        $deleteForm="";
        $changeKodForm="";
        foreach ($entities as $entity){
            $editForm[$entity->getId()] = $this->createForm(new \Itc\KidsBundle\Form\Template\AttrType($entity->getAttrtype()->getName()), $entity,
                     array("attr" => array("new" => true, "class"=>$entity->getAttrtype()->getName())))->createView();
            $deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())
                            ->createView();
            $changeKodForm[$entity->getId()] = 
                    $this->createChangeKodForm($entity->getKod())
                            ->createView();
            }  
        return array(
            'entities' => $entities,
            'templid'=> $templid, 
            'edit_form'=>$editForm,
            'delete_form'=>$deleteForm,
            'kod_form' =>$changeKodForm
        );
    }
    private function createChangeKodForm( $kod ){

       return  $this->createFormBuilder(
                    array('kod' => $kod))
                    ->add( 'kod', 'hidden' )
                    ->getForm();
    }
      /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}/change_attr_kod", name="change_attr_kod",
     * requirements={"id" = "\d+"}) 
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\Template:index.html.twig")
     */
    public function updateKodAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();

        $templid = $em->getRepository('ItcKidsBundle:Template\Attr')->find($id)->getTemplId();
        
        $form = $this->createChangeKodForm($id);
        $form->bind($request);
        $data = $form->getData();
        $newKod = $data['kod'];
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->getRepository('ItcKidsBundle:Template\Attr')
                        ->createQueryBuilder('M')
                        ->select('M.kod')
                        ->where('M.id = :id')
                        ->setParameter('id', $id);
            $entity = $qb->getQuery()->getResult();
            
            $oldKod = $entity[0]['kod'];
            
            $qb = $em->createQueryBuilder('M')
                        ->update('ItcKidsBundle:Template\Attr', 'M')
                        ->set('M.kod', $oldKod)
                        ->where('M.kod = :kod')
                        ->setParameter('kod', $newKod);               
            $qb->getQuery()->execute();

            $qb = $em->createQueryBuilder('M')
                        ->update('ItcKidsBundle:Template\Attr', 'M')
                        ->set('M.kod', $newKod)
                        ->where('M.id = :id')
                        ->setParameter('id', $id);
            $qb->getQuery()->execute();  
            return $this->redirect($this->generateUrl('template_edit', array(
                        'id' => $templid
                    )));
        }else{            
            return false;
        }
     }
    /**
     * Displays a form to create a new Template\Attr entity.
     *
     * @Route("/{templid}/new", name="attributs_new")
     * @Template()
     */
    public function newAction($templid)
    {
        $entity = new Attr();
        $form   = $this->createForm(new AttrType("appendedDropdownButton"), $entity,
                     array("attr" => array("new" => false, "class"=>"appendedDropdownButton")));

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'templid'=> $templid 
        );
    }

    /**
     * Creates a new Template\Attr entity.
     *
     * @Route("/{templid}/create", name="attributs_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\Attr:new.html.twig")
     */
    public function createAction(Request $request, $templid)
    {
        $em = $this->getDoctrine()->getManager();

        $template = $em->getRepository('ItcKidsBundle:Template\Template')->find($templid);

        $entity  = new Attr();
        $entity->setTemplId($templid);
        $entity->setTempl($template);

        $form = $this->createForm(new AttrType("appendedDropdownButton"), $entity,
                     array("attr" => array("new" => true, "class"=>"appendedDropdownButton")));
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('template_edit', array(
                        'id' => $templid
                    )));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Template\Attr entity.
     *
     * @Route("/{templid}/edit/{id}", name="attributs_edit")
     * @Template()
     */
    public function editAction($templid, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\Attr')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\Attr entity.');
        }

        $editForm = $this->createForm(new AttrType("appendedDropdownButton"), $entity,
                     array("attr" => array("new" => true, "class"=>"appendedDropdownButton")));
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'templid'     => $templid
        );
    }

    /**
     * Edits an existing Template\Attr entity.
     *
     * @Route("/{templid}/update/{id}", name="attributs_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Template\Attr:edit.html.twig")
     */
    public function updateAction(Request $request, $templid, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Template\Attr')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Template\Attr entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AttrType($entity->getAttrtype()->getName()), $entity,
                     array("attr" => array("new" => true, "class"=>"appendedDropdownButton")));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('template_edit', array(
                    'id' => $templid
                )));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'templid'     => $templid
        );
    }

    /**
     * Deletes a Template\Attr entity.
     *
     * @Route("/{templid}/delete/{id}", name="attributs_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $templid, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Template\Attr')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Template\Attr entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('template_edit', array('id' => $templid)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
