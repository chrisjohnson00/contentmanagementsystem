<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\Setting;
use cjohnson\ContentManagementSystemBundle\Form\SettingType;

/**
 * Setting controller.
 *
 */
class SettingController extends Controller
{

    /**
     * Lists all Setting entities.
     *
     */
    public function headerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:Setting')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:Setting:header.html.twig', array(
            'settings' => $entities,
        ));
    }
    /**
     * Lists all Setting entities.
     *
     */
    public function footerAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('cjohnsonContentManagementSystemBundle:Setting')->findAll();

        return $this->render('cjohnsonContentManagementSystemBundle:Setting:footer.html.twig', array(
            'settings' => $entities,
        ));
    }
}
