<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\PageRow;
use cjohnson\ContentManagementSystemBundle\Form\PageRowType;
use Symfony\Component\HttpFoundation\Response;

/**
 * PageRow controller.
 *
 */
class PageRowController extends Controller
{

    /**
     * Lists all PageRow entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:PageRow:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new PageRow entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PageRow();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity->setRank(999);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Row has been added!');

            return $this->redirect($this->generateUrl('admin_page_show', array('id' => $entity->getPage()->getId())));
        }

        /**
         * @TODO form validation failure should take you back to the admin_page_show view
         */

        return $this->render('cjohnsonContentManagementSystemBundle:PageRow:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PageRow entity.
     *
     * @param PageRow $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     * @deprecated Use cjohnsonContentManagementSystemBundle\Helpers\PageRowHelper->createCreateForm(Controller, PageRow)
     */
    public function createCreateForm(PageRow $entity)
    {
        $form = $this->createForm(new PageRowType(), $entity, array(
            'action' => $this->generateUrl('admin_pagerow_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Add'));

        return $form;
    }

    /**
     * Displays a form to create a new PageRow entity.
     *
     */
    public function newAction()
    {
        $entity = new PageRow();
        $form   = $this->createCreateForm($entity);

        return $this->render('cjohnsonContentManagementSystemBundle:PageRow:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PageRow entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find PageRow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:PageRow:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PageRow entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find PageRow entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:PageRow:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a PageRow entity.
     *
     * @param PageRow $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(PageRow $entity)
    {
        $form = $this->createForm(new PageRowType(), $entity, array(
            'action' => $this->generateUrl('admin_pagerow_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing PageRow entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find PageRow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pagerow_edit', array('id' => $id)));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:PageRow:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PageRow entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find PageRow entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pagerow'));
    }

    /**
     * Deletes a PageRow entity.
     *
     */
    public function deleteThenRedirectToShowPageAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        /**
         * @var $entity \cjohnson\ContentManagementSystemBundle\Entity\PageRow
         */
        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find PageRow entity.');
        }
        $pageId = $entity->getPage()->getId();

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Row has been deleted!');

        return $this->redirect($this->generateUrl('admin_page_show', array('id' => $pageId)));
    }

    /**
     * Redirects a PageRow entity to it's row.
     *
     */
    public function redirectToShowRowAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        /**
         * @var $entity \cjohnson\ContentManagementSystemBundle\Entity\PageRow
         */
        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find PageRow entity.');
        }
        $rowId = $entity->getRow()->getId();


        return $this->redirect($this->generateUrl('admin_row_show', array('id' => $rowId)));
    }

    /**
     * Creates a form to delete a PageRow entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pagerow_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function rankListAction(Request $request)
    {
        $data             = $request->request->all();
        $pageRowIdsRanked = $data['pageRow'];

        if (empty($pageRowIdsRanked))
            throw new \Exception("Empty pageRow parameter");

        $em = $this->getDoctrine()->getManager();
        /**
         * @var \cjohnson\ContentManagementSystemBundle\Entity\PageRowRepository
         */
        $pageRowRepository = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow');

        $i = 1;
        foreach ($pageRowIdsRanked as $pageRowId)
        {
            /**
             * @var PageRow $entity
             */
            $entity = $pageRowRepository->find($pageRowId);
            $entity->setRank($i);
            $i++;
        }
        $em->flush();

        return new Response(null, 204);
    }
}
