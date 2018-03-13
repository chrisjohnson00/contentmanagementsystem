<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\PageRow;
use cjohnson\ContentManagementSystemBundle\Helpers\PageHelper;
use cjohnson\ContentManagementSystemBundle\Helpers\PageRowHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\Page;
use cjohnson\ContentManagementSystemBundle\Form\PageNewType;
use cjohnson\ContentManagementSystemBundle\Form\PageEditType;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:Page')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:Page:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Page entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Page();
        $entity->setPublished(false);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Page has been added!');

            return $this->redirect($this->generateUrl('admin_page_show', array('id' => $entity->getId())));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:Page:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $entity)
    {
        $form = $this->createForm(new PageNewType(), $entity, array(
            'action' => $this->generateUrl('admin_page_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     */
    public function newAction()
    {
        $entity = new Page();
        $form   = $this->createCreateForm($entity);

        return $this->render('cjohnsonContentManagementSystemBundle:Page:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('cjohnsonContentManagementSystemBundle:Page')->find($id);

        if (!$page)
        {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }
        $rows = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->findAllByPageRankOrder($page);

        $deleteForm = $this->createDeleteForm($id);

        $pageRowHelper = new PageRowHelper();
        $pageRow       = new PageRow();
        $pageRow->setPage($page);
        /**
         * @TODO how can I make this form not show rows that are already on the page??
         */
        $pageRowForm = $pageRowHelper->createCreateForm($this, $pageRow);

        $pageHelper = new PageHelper();
        list($pageRows, $rowComponents) = $pageHelper->getRowsAndComponents($em, $page);


        return $this->render('cjohnsonContentManagementSystemBundle:Page:show.html.twig', array(
            'entity'            => $page,
            'page'            => $page,
            'delete_form'       => $deleteForm->createView(),
            'pageRowForm'       => $pageRowForm->createView(),
            'rows'              => $rows,
            'pageRows'          => $pageRows,
            'rowComponentArray' => $rowComponents

        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Page')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:Page:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Page entity.
     *
     * @param Page $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Page $entity)
    {
        $form = $this->createForm(new PageEditType(), $entity, array(
            'action' => $this->generateUrl('admin_page_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Page entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Page')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Page has been updated!');

            return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $id)));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:Page:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:Page')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Page has been deleted!');

        }

        return $this->redirect($this->generateUrl('admin_page'));
    }

    /**
     * Creates a form to delete a Page entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_page_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
