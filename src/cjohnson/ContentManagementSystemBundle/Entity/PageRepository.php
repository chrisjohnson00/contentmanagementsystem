<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    /**
     * @return array
     * @TODO make this a cached query... <5 min?
     */
    public function getAllPageUris()
    {
        return $this->getEntityManager()->createQuery("SELECT p FROM
                                                        cjohnsonContentManagementSystemBundle:Page p
                                                        where p.published = true")
            ->getResult();
    }

    public function findPublishedByUri($uri)
    {
        /** @var  $pages \cjohnson\ContentManagementSystemBundle\Entity\Page[] */
        $pages = $this->getAllPageUris();
        foreach ($pages as $page)
        {
            if ($page->getUri() == $uri)
                return $page;
        }

        return null;
    }

    public function findHomePage($ignored)
    {
        return $this->getEntityManager()->createQuery("SELECT p FROM
                                                        cjohnsonContentManagementSystemBundle:Page p
                                                        where p.isHomePage=true
                                                        and p.published = true")
            ->getOneOrNullResult();
    }
}
