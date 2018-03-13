<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\RowComponent;
use cjohnson\ContentManagementSystemBundle\Form\RowComponentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * RowComponent controller.
 *
 */
class RowComponentController extends Controller
{

    /**
     * Lists all RowComponent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:RowComponent:index.html.twig', array('entities' => $entities,));
    }

    /**
     * Creates a new RowComponent entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new RowComponent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Component has been added!');

            return $this->redirect($this->generateUrl('admin_row_show', array('id' => $entity->getRow()->getId())));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:RowComponent:new.html.twig', array('entity' => $entity,
                                                                                                       'form'   => $form->createView(),));
    }

    /**
     * Creates a form to create a RowComponent entity.
     *
     * @param RowComponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RowComponent $entity)
    {
        $form = $this->createForm(new RowComponentType(), $entity, array('action' => $this->generateUrl('admin_rowcomponent_create'),
                                                                         'method' => 'POST',));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RowComponent entity.
     *
     */
    public function newAction()
    {
        $entity = new RowComponent();
        $form = $this->createCreateForm($entity);

        return $this->render('cjohnsonContentManagementSystemBundle:RowComponent:new.html.twig', array('entity' => $entity,
                                                                                                       'form'   => $form->createView(),));
    }

    /**
     * Finds and displays a RowComponent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find RowComponent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:RowComponent:show.html.twig', array('entity'      => $entity,
                                                                                                        'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing RowComponent entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find RowComponent entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('cjohnsonContentManagementSystemBundle:RowComponent:edit.html.twig', array('entity'      => $entity,
                                                                                                        'edit_form'   => $editForm->createView(),
                                                                                                        'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Creates a form to edit a RowComponent entity.
     *
     * @param RowComponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(RowComponent $entity)
    {
        $form = $this->createForm(new RowComponentType(), $entity, array('action' => $this->generateUrl('admin_rowcomponent_update', array('id' => $entity->getId())),
                                                                         'method' => 'PUT',));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing RowComponent entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find RowComponent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_rowcomponent_edit', array('id' => $id)));
        }

        return $this->render('cjohnsonContentManagementSystemBundle:RowComponent:edit.html.twig', array('entity'      => $entity,
                                                                                                        'edit_form'   => $editForm->createView(),
                                                                                                        'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Deletes a RowComponent entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->find($id);

            if (!$entity)
            {
                throw $this->createNotFoundException('Unable to find RowComponent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_rowcomponent'));
    }

    /**
     * Creates a form to delete a RowComponent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()->setAction($this->generateUrl('admin_rowcomponent_delete', array('id' => $id)))->setMethod('DELETE')->add('submit', 'submit', array('label' => 'Delete'))->getForm();
    }

    /**
     * Deletes a RowComponent entity.
     *
     */
    public function deleteThenRedirectToShowPageAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        /**
         * @var $entity \cjohnson\ContentManagementSystemBundle\Entity\RowComponent
         */
        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find RowComponent entity.');
        }
        $rowId = $entity->getRow()->getId();

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Component has been deleted!');

        return $this->redirect($this->generateUrl('admin_row_show', array('id' => $rowId)));
    }

    /**
     * Redirects a RowComponent entity to it's component
     *
     */
    public function redirectToShowComponentAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        /**
         * @var $entity \cjohnson\ContentManagementSystemBundle\Entity\RowComponent
         */
        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException('Unable to find RowComponent entity.');
        }
        $componentId = $entity->getComponent()->getId();

        return $this->redirect($this->generateUrl('admin_component_edit', array('id' => $componentId)));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function rankListAction(Request $request)
    {
        $data = $request->request->all();
        $rowComponentIdsRanked = $data['rowComponent'];

        if (empty($rowComponentIdsRanked))
        {
            throw new \Exception("Empty rowComponent parameter");
        }

        $em = $this->getDoctrine()->getManager();
        /**
         * @var \cjohnson\ContentManagementSystemBundle\Entity\RowComponentRepository
         */
        $rowComponentRepository = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent');

        $i = 1;
        foreach ($rowComponentIdsRanked as $id)
        {
            /**
             * @var RowComponent $entity
             */
            $entity = $rowComponentRepository->find($id);
            $entity->setRank($i);
            $i++;
        }
        $em->flush();

        return new Response(null, 204);
    }
}
