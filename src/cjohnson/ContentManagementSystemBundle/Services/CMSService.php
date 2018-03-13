<?php

/**
 * Created by PhpStorm.
 * User: cjohnson
 * Date: 8/25/16
 * Time: 3:33 PM
 */

namespace cjohnson\ContentManagementSystemBundle\Services;

use cjohnson\ContentManagementSystemBundle\Helpers\PageHelper;
use Symfony\Component\HttpFoundation\Response;
use cjohnson\ContentManagementSystemBundle\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;

/**
 * This service is used to access the CMS content without using built in templates.  It is also used by the CMS controllers.
 * You can use it to get a page, then get the HTML content of the page, or get a Response object using the page.
 * @package cjohnson\ContentManagementSystemBundle\Services
 */
class CMSService
{
    /**
     * This property holds the template engine, typically it's twig, but could be others
     * @var $templateEngine
     */
    private $templateEngine;
    /**
     * The doctrine entity manager
     * @var $entityManager EntityManagerInterface
     */
    private $entityManager;

    /**
     * CMSService constructor.
     *
     * @param $templateEngine
     * @param $em EntityManagerInterface
     */
    public function __construct($templateEngine, EntityManagerInterface $em)
    {
        $this->setTemplateEngine($templateEngine);
        $this->setEntityManager($em);
    }


    /**
     * Get the configured template engine (Twig usually)
     * @return mixed
     */
    private function getTemplateEngine()
    {
        return $this->templateEngine;
    }

    /**
     * Set the template engine
     * @param mixed $templateEngine
     */
    private function setTemplateEngine($templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * Use this to get the HTML content of the page, useful when you want to embed the CMS content inside other content.
     * @param $page A page object or null
     *
     * @return string The contents of the page in HTML
     */
    public function getPageContents($page)
    {
        if (is_null($page))
        {
            return "";
        }
        list($pageRows, $rowComponents) = $this->getPageRowsAndComponents($page);

        return $this->getTemplateEngine()->render('cjohnsonContentManagementSystemBundle:Default:display.html.twig', array('page'              => $page,
                                                                                                                           'pageRows'          => $pageRows,
                                                                                                                           'rowComponentArray' => $rowComponents));
    }

    /**
     * Use this when you want to render a Response from the CMS
     * @param $page A page object or null
     *
     * @return Response The contents of the page as a Reponse object
     */
    public function getPageResponse($page)
    {
        if (is_null($page))
        {
            return new Response();
        }
        list($pageRows, $rowComponents) = $this->getPageRowsAndComponents($page);

        return $this->getTemplateEngine()->renderResponse('cjohnsonContentManagementSystemBundle:Default:index.html.twig', array('page'              => $page,
                                                                                                                                 'pageRows'          => $pageRows,
                                                                                                                                 'rowComponentArray' => $rowComponents));

    }

    /**
     * Use this to get a page by its name!
     * @param string $name The name of the page as created in the admin UI
     *
     * @return \cjohnson\ContentManagementSystemBundle\Entity\Page
     */
    public function getPageByName($name)
    {
        /**
         * @var $page \cjohnson\ContentManagementSystemBundle\Entity\Page
         */
        $page = $this->getEntityManager()->getRepository('cjohnsonContentManagementSystemBundle:Page')->findOneByName($name);

        return $page;
    }

    /**
     * Use this to get a page by its URI/Slug
     * @param string $uri The URI of the page as specified in the admin UI
     *
     * @return \cjohnson\ContentManagementSystemBundle\Entity\Page
     */
    public function getPageByUri($uri)
    {
        /**
         * @var $page \cjohnson\ContentManagementSystemBundle\Entity\Page
         */
        $page = $this->getEntityManager()->getRepository('cjohnsonContentManagementSystemBundle:Page')->findOneByUri($uri);

        return $page;
    }

    /**
     * This gets all the Page Rows and Components for a given page
     * @param Page $page
     *
     * @return array The first element is the page rows, the second is the row components
     */
    private function getPageRowsAndComponents(Page $page)
    {
        $pageHelper = new PageHelper();
        list($pageRows, $rowComponents) = $pageHelper->getRowsAndComponents($this->getEntityManager(), $page);

        return array($pageRows, $rowComponents);
    }

    /**
     * Get the doctringe entity manager
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the doctrine entity manager
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}