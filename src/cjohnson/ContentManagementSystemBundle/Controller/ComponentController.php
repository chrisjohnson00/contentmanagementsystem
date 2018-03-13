<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\Component;
use cjohnson\ContentManagementSystemBundle\Form\ComponentType;

/**
 * Component controller.
 *
 */
class ComponentController extends Controller
{

    /**
     * Lists all Component entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:Component')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:Component:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Component entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Component();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Component has been added!');

            return $this->redirect($this->generateUrl('admin_component_show', array('id' => $entity->getId())));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:Component:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Component entity.
     *
     * @param Component $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Component $entity)
    {
        $form = $this->createForm(new ComponentType(), $entity, array(
            'action' => $this->generateUrl('admin_component_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Component entity.
     *
     */
    public function newAction()
    {
        $entity = new Component();
        $form   = $this->createCreateForm($entity);

        return $this->render('cjohnsonContentManagementSystemBundle:Component:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Component entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Component')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Component entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:Component:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Component entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Component')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Component entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:Component:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Component entity.
     *
     * @param Component $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Component $entity)
    {
        $form = $this->createForm(new ComponentType(), $entity, array(
            'action' => $this->generateUrl('admin_component_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Component entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Component')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Component entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Component has been updated!');

            return $this->redirect($this->generateUrl('admin_component_edit', array('id' => $id)));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:Component:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Component entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            /**
             * @var $entity \cjohnson\ContentManagementSystemBundle\Entity\Component
             */
            $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Component')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find Component entity.');
            }

            $rowComponents = $entity->getComponentRows();

            $em->remove($entity);
            $em->flush();

            foreach ($rowComponents as $rowComponent)
                $em->remove($rowComponent);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Component has been deleted!');

        }

        return $this->redirect($this->generateUrl('admin_component'));
    }

    /**
     * Creates a form to delete a Component entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_component_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
