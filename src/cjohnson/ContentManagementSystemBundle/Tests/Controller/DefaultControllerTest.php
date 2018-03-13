<?php

namespace cjohnson\ContentManagementSystemBundle\Tests\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\Component;
use cjohnson\ContentManagementSystemBundle\Entity\Page;
use cjohnson\ContentManagementSystemBundle\Entity\PageRow;
use cjohnson\ContentManagementSystemBundle\Entity\Row;
use cjohnson\ContentManagementSystemBundle\Entity\RowComponent;
use cjohnson\ContentManagementSystemBundle\Helpers\TestHelpers\TestPageHelper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    private $pageTestHelper;

    public function setUp()
    {
        $this->pageTestHelper = new TestPageHelper();
    }

    /**
     * @group Integration
     */
    public function testIndexAction()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        /**
         * @var $em \Doctrine\ORM\EntityManager
         */
        $em = $container->get('doctrine.orm.entity_manager');

        $page = $this->pageTestHelper->createFullPage($em);
        $crawler = $client->request('GET', '/' . $page->getUri());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /" . $page->getUri());
        $this->assertRegExp('/TEST CONTENT/', $client->getResponse()->getContent());
        $this->assertRegExp('/' . $page->getName() . '/', $client->getResponse()->getContent());
    }

    /**
     * @group Integration
     */
    public function testIndexActionNoHeader()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        /**
         * @var $em \Doctrine\ORM\EntityManager
         */
        $em = $container->get('doctrine.orm.entity_manager');

        $page = new Page();
        $page->setHideHeader(true);

        $page = $this->pageTestHelper->createFullPage($em, $page);
        $crawler = $client->request('GET', '/' . $page->getUri());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /" . $page->getUri());
        $this->assertRegExp('/TEST CONTENT/', $client->getResponse()->getContent());
        $this->assertNotRegExp('/' . $page->getName() . '/', $client->getResponse()->getContent());
    }

    /**
     * @group Integration
     */
    public function testHomeAction()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        /**
         * @var $em \Doctrine\ORM\EntityManager
         */
        $em = $container->get('doctrine.orm.entity_manager');
        $existingPage = $em->getRepository("cjohnsonContentManagementSystemBundle:Page")->findHomePage(true);
        if ($existingPage)
        {
            $em->remove($existingPage);
            $em->flush();
        }

        $page = new Page();
        $page->setIsHomePage(true);

        $page = $this->pageTestHelper->createFullPage($em, $page);
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /");
        $this->assertRegExp('/TEST CONTENT/', $client->getResponse()->getContent());
        $this->assertRegExp('/' . $page->getName() . '/', $client->getResponse()->getContent());
    }

}
