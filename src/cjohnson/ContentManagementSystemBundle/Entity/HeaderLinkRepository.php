<?php

namespace cjohnson\ContentManagementSystemBundle\Entity;

/**
 * HeaderLinkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HeaderLinkRepository extends \Doctrine\ORM\EntityRepository
{
    public function getHeaders()
    {
        return $this->getEntityManager()->createQuery("SELECT hl FROM
                                                        cjohnsonContentManagementSystemBundle:HeaderLink hl,
                                                        cjohnsonContentManagementSystemBundle:Page p
                                                        where p.published = true
                                                        and hl.page=p order by hl.sortOrder")
            ->getResult();
    }
}
