<?php
/**
 * Created by PhpStorm.
 * User: cjohnson
 * Date: 6/26/15
 * Time: 2:47 PM
 */

namespace cjohnson\ContentManagementSystemBundle\Helpers;


class PageHelper
{

    public function getRowsAndComponents($em, $page)
    {
        /**
         * @var $pageRows \cjohnson\ContentManagementSystemBundle\Entity\PageRow[]
         */
        $pageRows      = $em->getRepository('cjohnsonContentManagementSystemBundle:PageRow')->findAllByPageRankOrder($page);
        $rowComponents = array();
        foreach ($pageRows as $pageRow)
        {
            $rowsRowComponents = $em->getRepository('cjohnsonContentManagementSystemBundle:RowComponent')->findAllByRowRankOrder($pageRow->getRow());
            $rowComponents[]   = $rowsRowComponents;
        }

        return array($pageRows, $rowComponents);
    }

} 