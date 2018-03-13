<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\RowComponent;
use cjohnson\ContentManagementSystemBundle\Form\RowComponentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\Row;
use cjohnson\ContentManagementSystemBundle\Form\RowType;

/**
 * Row controller.
 *
 */
class RowController extends Controller
{

    /**
     * Lists all Row entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:Row')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:Row:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Row entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Row();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Row has been added!');

            return $this->redirect($this->generateUrl('admin_row_show', array('id' => $entity->getId())));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:Row:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Row entity.
     *
     * @param Row $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Row $entity)
    {
        $form = $this->createForm(new RowType(), $entity, array(
            'action' => $this->generateUrl('admin_row_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Row entity.
     *
     */
    public function newAction()
    {
        $entity = new Row();
        $form   = $this->createCreateForm($entity);

        return $this->render('cjohnsonContentManagementSystemBundle:Row:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Row entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Row')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Row entity.');
        }
        $rowComponents = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->findAllByRowRankOrder($entity);


        $deleteForm = $this->createDeleteForm($id);

        $rowComponent = new RowComponent();
        $rowComponent->setRow($entity);

        $rowComponentForm = $this->createRowComponentCreateForm($rowComponent);

        return $this->render('cjohnsonContentManagementSystemBundle:Row:show.html.twig', array(
            'entity'            => $entity,
            'delete_form'       => $deleteForm->createView(),
            'rowComponentForm'  => $rowComponentForm->createView(),
            'rowComponents'     => $rowComponents
        ));
    }

    /**
     * Displays a form to edit an existing Row entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Row')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Row entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:Row:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Row entity.
     *
     * @param Row $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Row $entity)
    {
        $form = $this->createForm(new RowType(), $entity, array(
            'action' => $this->generateUrl('admin_row_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Row entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Row')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Row entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Row has been updated!');

            return $this->redirect($this->generateUrl('admin_row_edit', array('id' => $id)));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:Row:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Row entity.
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
             * @var $entity \cjohnson\ContentManagementSystemBundle\Entity\Row
             */
            $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Row')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find Row entity.');
            }

            $pageRows = $entity->getRowPages();

            $em->remove($entity);
            $em->flush();

            foreach ($pageRows as $pageRow)
                $em->remove($pageRow);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Row has been deleted!');

        }

        return $this->redirect($this->generateUrl('admin_row'));
    }

    /**
     * Creates a form to delete a Row entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_row_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }


    public function createRowComponentCreateForm(RowComponent $entity)
    {
        $form = $this->createForm(new RowComponentType(), $entity, array(
            'action' => $this->generateUrl('admin_rowcomponent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Add'));

        return $form;
    }
}
