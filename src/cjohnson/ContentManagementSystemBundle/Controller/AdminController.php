<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('cjohnsonContentManagementSystemBundle:Admin:index.html.twig');
    }

}
