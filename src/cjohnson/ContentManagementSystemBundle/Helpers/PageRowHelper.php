<?php
/**
 * Created by PhpStorm.
 * User: cjohnson
 * Date: 6/2/15
 * Time: 9:43 PM
 */

namespace cjohnson\ContentManagementSystemBundle\Helpers;


use cjohnson\ContentManagementSystemBundle\Entity\PageRow;
use cjohnson\ContentManagementSystemBundle\Form\PageRowType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageRowHelper
{
    /**
     * Creates a form to create a PageRow entity.
     *
     * @param Controller $controller
     * @param PageRow    $entity
     *
     * @return \Symfony\Component\Form\Form
     */
    public function createCreateForm(Controller $controller, PageRow $entity)
    {
        $form = $controller->createForm(new PageRowType(), $entity, array(
            'action' => $controller->generateUrl('admin_pagerow_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Add'));

        return $form;
    }

} 