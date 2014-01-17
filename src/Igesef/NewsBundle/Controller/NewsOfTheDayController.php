<?php

namespace Igesef\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Igesef\NewsBundle\Entity\NewsOfTheDay;
use Igesef\NewsBundle\Form\NewsOfTheDayType;

/**
 * NewsOfTheDay controller.
 *
 * @Route("/newsoftheday")
 */
class NewsOfTheDayController extends Controller
{

    /**
     * Lists all NewsOfTheDay entities.
     *
     * @Route("/", name="newsoftheday")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IgesefNewsBundle:NewsOfTheDay')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new NewsOfTheDay entity.
     *
     * @Route("/", name="newsoftheday_create")
     * @Method("POST")
     * @Template("IgesefNewsBundle:NewsOfTheDay:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NewsOfTheDay();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('newsoftheday_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a NewsOfTheDay entity.
    *
    * @param NewsOfTheDay $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(NewsOfTheDay $entity)
    {
        $form = $this->createForm(new NewsOfTheDayType(), $entity, array(
            'action' => $this->generateUrl('newsoftheday_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new NewsOfTheDay entity.
     *
     * @Route("/new", name="newsoftheday_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NewsOfTheDay();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a NewsOfTheDay entity.
     *
     * @Route("/{id}", name="newsoftheday_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IgesefNewsBundle:NewsOfTheDay')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsOfTheDay entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NewsOfTheDay entity.
     *
     * @Route("/{id}/edit", name="newsoftheday_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IgesefNewsBundle:NewsOfTheDay')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsOfTheDay entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a NewsOfTheDay entity.
    *
    * @param NewsOfTheDay $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NewsOfTheDay $entity)
    {
        $form = $this->createForm(new NewsOfTheDayType(), $entity, array(
            'action' => $this->generateUrl('newsoftheday_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NewsOfTheDay entity.
     *
     * @Route("/{id}", name="newsoftheday_update")
     * @Method("PUT")
     * @Template("IgesefNewsBundle:NewsOfTheDay:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IgesefNewsBundle:NewsOfTheDay')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsOfTheDay entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('newsoftheday_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a NewsOfTheDay entity.
     *
     * @Route("/{id}", name="newsoftheday_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IgesefNewsBundle:NewsOfTheDay')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NewsOfTheDay entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('newsoftheday'));
    }

    /**
     * Creates a form to delete a NewsOfTheDay entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('newsoftheday_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
