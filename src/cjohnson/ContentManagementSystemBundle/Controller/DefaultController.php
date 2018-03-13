<?php

namespace cjohnson\ContentManagementSystemBundle\Controller;

use cjohnson\ContentManagementSystemBundle\Helpers\PageHelper;
use cjohnson\ContentManagementSystemBundle\Services\CMSService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($uri)
    {
        return $this->getPage("findPublishedByUri", $uri);
    }

    public function homeAction()
    {
        return $this->getPage("findHomePage", null);
    }

    public function headerAction()
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $headerLinks \cjohnson\ContentManagementSystemBundle\Entity\HeaderLink[]
         */
        $headerLinks = $em->getRepository('cjohnsonContentManagementSystemBundle:HeaderLink')->getHeaders();

        return $this->render('cjohnsonContentManagementSystemBundle:Default:header.html.twig', array('headerLinks' => $headerLinks));
    }

    private function getPage($queryType, $uri)
    {
        $em = $this->getDoctrine()->getManager();

        /**
         * @var $page \cjohnson\ContentManagementSystemBundle\Entity\Page
         */
        $page = $em->getRepository('cjohnsonContentManagementSystemBundle:Page')->$queryType($uri);

        if (!$page)
        {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        /**
         * @var $cmsService CMSService
         */
        $cmsService = $this->container->get('cjohnson.contentManagementSystemBundle');

        return $this->setResponseCaching($cmsService->getPageResponse($page), $page->getCacheTTL());
    }

    private function setResponseCaching(Response $response, $ttl)
    {
        if (is_null($ttl))
        {
            $ttl = 86400;
        }
        //@TODO override default via configuration
        $response->setSharedMaxAge($ttl);
        $response->setMaxAge($ttl);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->setVary('Accept-Encoding');
        $response->setPublic();

        return $response;
    }
}
