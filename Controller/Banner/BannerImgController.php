<?php

namespace Itc\KidsBundle\Controller\Banner;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Banner\BannerImg;
use Itc\KidsBundle\Form\Banner\BannerImgType;
use Itc\AdminBundle\Tools\TranslitGenerator;
use Itc\AdminBundle\Tools\BreadCrumbsGeneration;
use Symfony\Component\Locale\Locale;
use Itc\AdminBundle\Tools\LanguageHelper;
use Imagine\Gd\Imagine;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Itc\AdminBundle\ItcAdminBundle;
/**
 * Banner\BannerImg controller.
 *
 * @Route("/bannerimg")
 */
class BannerImgController extends Controller
{
    /**
     * Lists all Banner\BannerImg entities.
     *
     * @Route("/{coulonpage}/{page}/{parent_id}", name="bannerimg",
     * requirements={"parent_id" = "\d+", "coulonpage" = "\d+","page" = "\d+"}, 
     * defaults={ "parent_id" = null, "coulonpage" = "100", "page"=1})
     * @Template()
     */
    public function indexAction($parent_id = null, $coulonpage = 100, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $locale =  LanguageHelper::getLocale();
        $deleteForm = array(); 
        $visibleForm = array();
        $changeKodForm = array();
        $entities = array();
        if($parent_id!=null)
        {
            $repo= $em->getRepository('ItcKidsBundle:Banner\BannerImg');
            $qb = $repo->createQueryBuilder('M')
                ->select('M')
                ->where('M.banner_id = :banner_id')
               ->setParameter('banner_id', $parent_id)
                ->orderBy('M.kod', 'ASC');
        
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $qb,
            $this->get('request')->query->get('page', 1)/*page number*/,
            $coulonpage/*limit per page*/
        );


                foreach ($entities as $entity){
            
            $deleteForm[$entity->getId()] = $this->createDeleteForm($entity->getId())
                            ->createView();
            $visibleForm[$entity->getId()] = $this->createVisibleForm($entity)
                            ->createView();
           $changeKodForm[$entity->getId()] = 
                    $this->createChangeKodForm($entity->getKod(), $coulonpage, $page)
                            ->createView();
        }
}
        return array(
            'route'     =>'bannerimg',
            'entities' => $entities,
            'locale'    => $locale,
            'parent_id' => $parent_id,
            'coulonpage' => $coulonpage,
            'delete_form'       => $deleteForm,
            'visible_form' => $visibleForm,
            'change_kod_form' => $changeKodForm,
        );
    }

    /**
     * Finds and displays a Banner\BannerImg entity.
     *
     * @Route("/{id}/show", name="bannerimg_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Banner\BannerImg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner\BannerImg entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Banner\BannerImg entity.
     *
     * @Route("/new/{parent_id}", name="bannerimg_new",
     * requirements={"parent_id" = "\d+"})
     * @Template()
     */
    public function newAction($parent_id)
    {
        $entity = new BannerImg();        
        $form   = $this->createForm(new BannerImgType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'parent_id' => $parent_id,
        );
    }
    private function getKodForBannerImg()
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('ItcKidsBundle:Banner\BannerImg')
                                        ->createQueryBuilder('M')
                                        ->select('max(M.kod) kod');
        $res = $queryBuilder->getQuery()->execute();
        return $res[0]["kod"]+1;
    }
    /**
     * Creates a new Banner\BannerImg entity.
     *
     * @Route("/create/{parent_id}", name="bannerimg_create",
     * requirements={"parent_id" = "\d+"})
     * @Method("POST")
     * @Template("ItcKidsBundle:Banner\BannerImg:new.html.twig")
     */
    public function createAction(Request $request, $parent_id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity  = new BannerImg();
        $entity->setKod( $this->getKodForBannerImg( $parent_id ) );
        $banner= $em->getRepository('ItcKidsBundle:Banner\Banner')
                    ->findOneById($parent_id);
        $entity->setBanner($banner);
        
        $form = $this->createForm(new BannerImgType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            print_r($entity->getUrl());
            //$entity=$this->Resize($banner->getHeight(), $banner->getWidth(), $entity);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bannerimg_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    private function Resize($h,$w, $entity)
    {
        $imagine = new Imagine();
        $mode    = ImageInterface::THUMBNAIL_OUTBOUND;
        $size    = new Box($h, $w);
        
        $container = ItcAdminBundle::getContainer();
        $helper = 
            $container->get('vich_uploader.templating.helper.uploader_helper');
        $rootDir =  $container->get('kernel')->getRootDir();
        $relPath = $helper->asset($entity, 'image');
        $pathParts = explode("/", $relPath);
        $folder = "";
        for($i = 0; $i < count($pathParts) - 1; $i++)
        {
            $folder .= $pathParts[$i]."/";
        }
        $pathToImage = $rootDir. "/../web".
                       $helper->asset($entity, 'image');
        //$this->smallSrc = "small_{$this->src}";
        $pathToSmall =$rootDir."/../web".
                      $folder.$entity->getUrl();
        $image = $imagine->open($pathToImage);
        if($image->getSize()->getWidth() > 100 || 
                $image->getSize()->getHeight() > 100){
            $entity->setImage(
                    $image->thumbnail($size, $mode)->save($pathToSmall));
        }
        else
        {
            $entity->setImage($image->save($pathToSmall));
        }
    }

        
    

    /**
     * Displays a form to edit an existing Banner\BannerImg entity.
     *
     * @Route("/{id}/edit", name="bannerimg_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Banner\BannerImg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner\BannerImg entity.');
        }

        $editForm = $this->createForm(new BannerImgType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Banner\BannerImg entity.
     *
     * @Route("/{id}/update", name="bannerimg_update")
     * @Template("ItcKidsBundle:Banner\BannerImg:edit.html.twig")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Banner\BannerImg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Banner\BannerImg entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BannerImgType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bannerimg_edit', array('id' => $id)));
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
     * @Route("/{id}/bannerimg_delete_ajax", name="bannerimg_delete_ajax")
     * defaults={"_format" = "json"})
     * @Template("ItcKidsBundle:Banner:deleteBannerimg.json.twig")
     * @Method("POST")
     */
    public function deleteBannerImgAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Banner\BannerImg')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Banner\BannerImg entity.');
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
     * Deletes a Banner\BannerImg entity.
     *
     * @Route("/{id}/delete", name="bannerimg_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Banner\BannerImg')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Banner\BannerImg entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bannerimg'));
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
                    ->add( 'visible', 'checkbox' )
                    ->getForm();
    }
    
    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}/change_kod", name="bannerimg_change_kod",
     * requirements={"id" = "\d+"}) 
     * @Template("ItcKidsBundle:Banner:banner_img_table.html.twig")
     * @Method("POST")
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
            $qb = $em->getRepository('ItcKidsBundle:Banner\BannerImg')
                        ->createQueryBuilder('M')
                        ->select('M.kod,M.banner_id')
                        ->where('M.id = :id')
                        ->setParameter('id', $id);
            $entity = $qb->getQuery()->getResult();
            
            $oldKod = $entity[0]['kod'];
            $banner_id = $entity[0]['banner_id'];
            
            $qb = $em->createQueryBuilder('M')
                        ->update('ItcKidsBundle:Banner\BannerImg', 'M')
                        ->set('M.kod', $oldKod)
                        ->where('M.kod = :kod')
                        ->setParameter('kod', $newKod)
                        ->andWhere('M.banner_id = :banner_id')
                        ->setParameter('banner_id', $banner_id);               
            $qb->getQuery()->execute();

            $qb = $em->createQueryBuilder('M')
                        ->update('ItcKidsBundle:Banner\BannerImg', 'M')
                        ->set('M.kod', $newKod)
                        ->where('M.id = :id')
                        ->setParameter('id', $id)
                        ->andWhere('M.banner_id = :banner_id')
                        ->setParameter('banner_id', $banner_id);
            $qb->getQuery()->execute();  
            return $this->indexAction($banner_id, $coulonpage, $page);
        }else{            
            return false;
        }
     }
    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}/bannerimg_update_visible", name="bannerimg_update_visible")
     * defaults={"_format" = "json"})
     * @Template("ItcKidsBundle:Banner:updateVisible.json.twig")
     * @Method("POST")
     */
    public function updateVisibleAction( Request $request, $id ){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ItcKidsBundle:Banner\BannerImg')
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
