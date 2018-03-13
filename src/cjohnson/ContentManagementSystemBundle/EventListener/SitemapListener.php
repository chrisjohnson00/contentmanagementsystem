<?php
/**
 * Created by PhpStorm.
 * User: cjohnson
 * Date: 8/8/15
 * Time: 2:51 PM
 */

namespace cjohnson\ContentManagementSystemBundle\EventListener;

use Symfony\Component\Routing\RouterInterface;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapListener implements SitemapListenerInterface
{
    private $router;
    private $entityManager;

    public function __construct(RouterInterface $router, $entityManager)
    {
        $this->router        = $router;
        $this->entityManager = $entityManager;
    }

    public function populateSitemap(SitemapPopulateEvent $event)
    {
        /**
         * @var $pages \cjohnson\ContentManagementSystemBundle\Entity\Page[]
         */
        $pages = $this->entityManager->getRepository('cjohnsonContentManagementSystemBundle:Page')->findBy(array('published' => true));

        foreach ($pages as $page)
        {
            if ($page->getIsHomePage())
            {
                $event->getGenerator()->addUrl(
                    new UrlConcrete(
                        $this->router->generate('cjohnson_content_management_system_homepage', array(), true),
                        $page->getModifiedDate(),
                        UrlConcrete::CHANGEFREQ_WEEKLY,
                        1
                    ),
                    'cms'
                );
            }
            else
            {
                $event->getGenerator()->addUrl(
                    new UrlConcrete(
                        $this->router->generate('cjohnson_content_management_system_dbroute', array('uri' => $page->getUri()), true),
                        $page->getModifiedDate(),
                        UrlConcrete::CHANGEFREQ_WEEKLY,
                        1
                    ),
                    'cms'
                );
            }
        }
    }
}