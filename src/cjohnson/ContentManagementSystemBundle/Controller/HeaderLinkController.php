<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use cjohnson\ContentManagementSystemBundle\Entity\HeaderLink;
use cjohnson\ContentManagementSystemBundle\Form\HeaderLinkType;

/**
 * HeaderLink controller.
 *
 */
class HeaderLinkController extends Controller
{

    /**
     * Lists all HeaderLink entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:HeaderLink')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new HeaderLink entity.
     *
     * @Template("cjohnsonContentManagementSystemBundle:HeaderLink:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new HeaderLink();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_headerlink_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a HeaderLink entity.
     *
     * @param HeaderLink $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(HeaderLink $entity)
    {
        $form = $this->createForm(new HeaderLinkType(), $entity, array(
            'action' => $this->generateUrl('admin_headerlink_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new HeaderLink entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $entity = new HeaderLink();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a HeaderLink entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:HeaderLink')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HeaderLink entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing HeaderLink entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:HeaderLink')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HeaderLink entity.');
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
    * Creates a form to edit a HeaderLink entity.
    *
    * @param HeaderLink $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(HeaderLink $entity)
    {
        $form = $this->createForm(new HeaderLinkType(), $entity, array(
            'action' => $this->generateUrl('admin_headerlink_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing HeaderLink entity.
     *
     * @Template("cjohnsonContentManagementSystemBundle:HeaderLink:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:HeaderLink')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find HeaderLink entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_headerlink_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a HeaderLink entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('cjohnsonContentManagementSystemBundle:HeaderLink')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find HeaderLink entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_headerlink'));
    }

    /**
     * Creates a form to delete a HeaderLink entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_headerlink_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
