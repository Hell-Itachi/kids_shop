<?php

namespace Itc\KidsBundle\Controller\Banner;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Banner\Banner;
use Itc\KidsBundle\Form\Banner\BannerType;

use Itc\AdminBundle\Tools\TranslitGenerator;
use Symfony\Component\Locale\Locale;
use Itc\AdminBundle\Tools\LanguageHelper;

/**
 * Banner\Banner controller.
 *
 * @Route("/banner")
 */
class BannerController extends Controller
{
    /**
     * Lists all Banner\Banner entities.
     *
     * @Route("/{coulonpage}/{page}/{parent_id}", name="banner",
     * requirements={"parent_id" = "\d+", "coulonpage" = "\d+","page" = "\d+"}, 
     * defaults={ "parent_id" = null, "coulonpage" = "100", "page"=1})
     * @Template()
     */
    public function indexAction($parent_id = null, $coulonpage = 100, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $locale =  LanguageHelper::getLocale();
        $repo = $em->getRepository('ItcKidsBundle:Banner\Banner');
        $qb = $repo->createQueryBuilder('M')
                        ->select('M')
                        ->orderBy('M.kod', 'ASC'); 
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $qb,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $coulonpage/*limit per page*/
        );
        $deleteForm = array(); 
        $visibleForm = array();
        $changeKodForm = array();
        foreach ($entities as $entity){
            
            $deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())
                            ->createView();
            $visibleForm[$entity->getId()] = $this->createVisibleForm($entity)
                            ->createView();
           $changeKodForm[$entity->getId()] = 
                    $this->createChangeKodForm($entity->getKod(), $coulonpage, $page)
                            ->createView();
        }
        return array(
            'entities'  => $entities,
            'route'     => 'banner',
            'parent_id' => null,
            'locale'    => $locale,
            'coulonpage' => $coulonpage,
            'delete_form' => $deleteForm,
            'visible_form' => $visibleForm,
            'change_kod_form' => $changeKodForm,
        );
    }

    /**
     * Finds and displays a Banner\Banner entity.
     *
     * @Route("/{id}/show", name="banner_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Banner\Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner\Banner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Banner\Banner entity.
     *
     * @Route("/new", name="banner_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Banner();
        $form   = $this->createForm(new BannerType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Banner\Banner entity.
     *
     * @Route("/create", name="banner_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Banner\Banner:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Banner();
        $languages  = LanguageHelper::getLanguages();
        $form = $this->createForm(new BannerType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setKod( $this->getKodForBanner() );
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('banner_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'languages' => $languages,
        );
    }
    private function getKodForBanner()
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('ItcKidsBundle:Banner\Banner')
                                        ->createQueryBuilder('M')
                                        ->select('max(M.kod) kod');
        $res = $queryBuilder->getQuery()->execute();
        return $res[0]["kod"]+1;
    }
    /**
     * Displays a form to edit an existing Banner\Banner entity.
     *
     * @Route("/{id}/edit", name="banner_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Banner\Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner\Banner entity.');
        }

        $editForm = $this->createForm(new BannerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Banner\Banner entity.
     *
     * @Route("/{id}/update", name="banner_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Banner\Banner:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Banner\Banner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner\Banner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BannerType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('banner_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Banner\Banner entity.
     * 
     * @Route("/{id}/banner_delete_ajax", name="banner_delete_ajax")
     * defaults={"_format" = "json"})
     * @Method("POST")
     * @Template("ItcKidsBundle:Banner:deleteBanner.json.twig")
     * @Method("POST")
     */
    public function deleteBannerAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Banner\Banner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Banner\Banner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }else{            
            print_r($form->getErrors());
        }
        return array(
            'entity' => $entity,
        );
    }
    /**
     * Deletes a MenuSys entity.
     *
     * @Route("/{id}/delete", name="banner_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Banner\Banner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Banner\Banner entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('banner'));
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    private function createChangeKodForm( $kod , $coulonpage= null, $page = null ){

       return  $this->createFormBuilder(
                    array('kod' => $kod, 'coulonpage' => $coulonpage, 'page' => $page))
                    ->add( 'kod', 'hidden' )
                    ->add( 'coulonpage', 'hidden' )
                    ->add( 'page', 'hidden' )
                    ->getForm();
    }
    /**
     * @param type $entity
     */
    private function createVisibleForm( $entity ){

       return  $this->createFormBuilder( $entity )
                    ->add( 'is_used', 'checkbox' )
                    ->getForm();
    }
    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}/change_kod", name="banner_change_kod",
     * requirements={"id" = "\d+"}) 
     * @Method("POST")
     * @Template("ItcKidsBundle:Banner:banner_table.html.twig")
     */
    public function updateKodAction(Request $request, $id)
    {
        $form = $this->createChangeKodForm($id);
        $form->bind($request);
        $data = $form->getData();
        $newKod = $data['kod'];
        $coulonpage = $data['coulonpage'];
        $page = $data['page'];
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->getRepository('ItcKidsBundle:Banner\Banner')
                        ->createQueryBuilder('M')
                        ->select('M.kod')
                        ->where('M.id = :id')
                        ->setParameter('id', $id);
            $entity = $qb->getQuery()->getResult();
            
            $oldKod = $entity[0]['kod'];
            
            $qb = $em->createQueryBuilder('M')
                        ->update('ItcKidsBundle:Banner\Banner', 'M')
                        ->set('M.kod', $oldKod)
                        ->where('M.kod = :kod')
                        ->setParameter('kod', $newKod);               
            $qb->getQuery()->execute();

            $qb = $em->createQueryBuilder('M')
                        ->update('ItcKidsBundle:Banner\Banner', 'M')
                        ->set('M.kod', $newKod)
                        ->where('M.id = :id')
                        ->setParameter('id', $id);
            $qb->getQuery()->execute();  
            return $this->indexAction(null, $coulonpage, $page);
        }else{            
            return false;
        }
     }
         /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}/banner_update_visible", name="banner_update_visible")
     * defaults={"_format" = "json"})
     * @Method("POST")
     * @Template("ItcKidsBundle:Banner:updateVisible.json.twig")
     */
    public function updateVisibleAction( Request $request, $id ){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ItcKidsBundle:Banner\Banner')
                ->find($id);  
        $imageForm = $this->createVisibleForm( $entity );
        $imageForm->bind( $request );
        
        if ( $imageForm->isValid() ) {
            $em->flush();
        }else{            
            print_r($imageForm->getErrors());
        }
        return array(
            'entity' => $entity,
        );
        
    }    
     
}
