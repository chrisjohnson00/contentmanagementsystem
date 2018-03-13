<?php

/**
 * Created by PhpStorm.
 * User: cjohnson
 * Date: 8/25/16
 * Time: 4:34 PM
 */
namespace cjohnson\ContentManagementSystemBundle\Helpers\TestHelpers;


use cjohnson\ContentManagementSystemBundle\Entity\Component;
use cjohnson\ContentManagementSystemBundle\Entity\Page;
use cjohnson\ContentManagementSystemBundle\Entity\PageRow;
use cjohnson\ContentManagementSystemBundle\Entity\Row;
use cjohnson\ContentManagementSystemBundle\Entity\RowComponent;

class TestPageHelper
{
    /**
     * @param \Doctrine\ORM\EntityManager $em
     *
     * @return Page
     */
    public function createFullPage(\Doctrine\ORM\EntityManager $em, Page $page = null)
    {
        if (is_null($page))
        {
            $page = new Page();
        }
        $row = new Row();
        $component = new Component();
        $rowComponent = new RowComponent();
        $pageRow = new PageRow();

        $component->setName("Test Component Created At " . time());
        $component->setContent("TEST CONTENT");

        $em->persist($component);
        $em->flush();

        $row->setName("Test Row Create At " . time());

        $em->persist($row);
        $em->flush();

        $rowComponent->setComponent($component);
        $rowComponent->setRow($row);

        $em->persist($rowComponent);
        $em->flush();

        if (is_null($page->getName()))
        {
            $page->setName("Test Page Create At " . time());
        }
        if (is_null($page->getPublished()))
        {
            $page->setPublished(true);
        }
        if (is_null($page->getHideHeader()))
        {
            $page->setHideHeader(false);
        }

        $em->persist($page);
        $em->flush();

        $pageRow->setRow($row);
        $pageRow->setPage($page);

        $em->persist($pageRow);
        $em->flush();

        sleep(1); //so subsequent created pages cannot have the same time

        return $page;
    }
}