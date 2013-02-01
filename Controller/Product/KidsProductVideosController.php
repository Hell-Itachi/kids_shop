<?php

namespace Itc\KidsBundle\Controller\Product;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itc\KidsBundle\Entity\Product\KidsProductVideos;
use Itc\KidsBundle\Form\Product\KidsProductVideosType;

/**
 * Product\KidsProductVideos controller.
 *
 * @Route("/videos")
 */
class KidsProductVideosController extends Controller
{
    /**
     * Lists all Product\KidsProductVideos entities.
     *
     * @Route("{video_gal}/", name="videos")
     * @Template()
     */
    public function indexAction($video_gal)
    {
        $em = $this->getDoctrine()->getManager();

        $galary = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->find($video_gal);
        
        $entities=$galary->getVideo();
        
        return array(
            'entities' => $entities,
            'video_gal'=> $video_gal
        );
    }

    /**
     * Finds and displays a Product\KidsProductVideos entity.
     *
     * @Route("/{id}/show", name="videos_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product\KidsProductVideos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Product\KidsProductVideos entity.
     *
     * @Route("/{video_gal}/new", name="videos_new")
     * @Template()
     */
    public function newAction($video_gal)
    {
        $entity = new KidsProductVideos();
        $form   = $this->createForm(new KidsProductVideosType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'video_gal' => $video_gal
        );
    }

    /**
     * Creates a new Product\KidsProductVideos entity.
     *
     * @Route("{video_gal}/create", name="videos_create")
     * @Method("POST")
     * @Template("ItcKidsBundle:Product\KidsProductVideos:new.html.twig")
     */
    public function createAction(Request $request, $video_gal)
    {
        $entity  = new KidsProductVideos();
        $form = $this->createForm(new KidsProductVideosType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $gallery = $em->getRepository('ItcKidsBundle:Product\KidsProductVideoGalary')->find($video_gal);
            $entity->setVideoGallery($gallery);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('videos_edit', array('id' => $entity->getId(), 'video_gal'=>$video_gal)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'video_gal' => $video_gal
        );
    }

    /**
     * Displays a form to edit an existing Product\KidsProductVideos entity.
     *
     * @Route("/{video_gal}/{id}/edit", name="videos_edit")
     * @Template()
     */
    public function editAction($video_gal,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product\KidsProductVideos entity.');
        }

        $editForm = $this->createForm(new KidsProductVideosType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'video_gal'   => $video_gal
        );
    }

    /**
     * Edits an existing Product\KidsProductVideos entity.
     *
     * @Route("/{video_gal}/{id}/update", name="videos_update")
     * @Method("POST")
     * @Template("ItcKidsBundle:Product\KidsProductVideos:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $video_gal)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product\KidsProductVideos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new KidsProductVideosType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('videos_edit', array('id' => $id, 'video_gal'=>$video_gal)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product\KidsProductVideos entity.
     *
     * @Route("/{id}/delete", name="videos_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ItcKidsBundle:Product\KidsProductVideos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product\KidsProductVideos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('videos'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
