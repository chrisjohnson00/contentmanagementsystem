<?php

/**
 * Created by PhpStorm.
 * User: cjohnson
 * Date: 8/25/16
 * Time: 3:56 PM
 */

namespace cjohnson\ContentManagementSystemBundle\Tests\Controller;

use cjohnson\ContentManagementSystemBundle\Entity\Component;
use cjohnson\ContentManagementSystemBundle\Entity\Page;
use cjohnson\ContentManagementSystemBundle\Entity\PageRow;
use cjohnson\ContentManagementSystemBundle\Entity\Row;
use cjohnson\ContentManagementSystemBundle\Entity\RowComponent;
use cjohnson\ContentManagementSystemBundle\Helpers\TestHelpers\TestPageHelper;
use cjohnson\ContentManagementSystemBundle\Services\CMSService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CMSServiceTest extends WebTestCase
{
    /**
     * @var $cmsService CMSService
     */
    private $cmsService;
    /**
     * @var $testPageHelper TestPageHelper
     */
    private $testPageHelper;
    private $em;

    public function setUp()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->cmsService = $container->get('cjohnson.contentManagementSystemBundle');
        $this->testPageHelper = new TestPageHelper();
    }

    public function testRenderContent()
    {
        $page = $this->testPageHelper->createFullPage($this->em);
        $this->assertRegExp('/TEST CONTENT/', $this->cmsService->getPageContents($page));
    }

    public function testPageByName()
    {
        $page = $this->testPageHelper->createFullPage($this->em);
        $newPage = $this->cmsService->getPageByName($page->getName());
        $this->assertSame($page, $newPage);
    }

    public function testPageByUri()
    {
        $page = $this->testPageHelper->createFullPage($this->em);
        $newPage = $this->cmsService->getPageByUri($page->getUri());
        $this->assertSame($page, $newPage);
    }

    public function testGetPageContentWithoutPage()
    {
        $page = $this->cmsService->getPageByName(time());
        $content = $this->cmsService->getPageContents($page);
        $this->assertSame('',$content);
    }


    public function testGetPageResponseWithoutPage()
    {
        $page = $this->cmsService->getPageByName(time());
        $response = $this->cmsService->getPageResponse($page);
        $this->assertInstanceOf(Response::class,$response);
    }
}