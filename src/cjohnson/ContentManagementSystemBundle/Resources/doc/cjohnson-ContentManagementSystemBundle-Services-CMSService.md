cjohnson\ContentManagementSystemBundle\Services\CMSService
===============

This service is used to access the CMS content without using built in templates.  It is also used by the CMS controllers.

You can use it to get a page, then get the HTML content of the page, or get a Response object using the page.


* Class name: CMSService
* Namespace: cjohnson\ContentManagementSystemBundle\Services





Properties
----------


### $templateEngine

    private  $templateEngine

This property holds the template engine, typically it's twig, but could be others



* Visibility: **private**


### $entityManager

    private  $entityManager

The doctrine entity manager



* Visibility: **private**


Methods
-------


### __construct

    mixed cjohnson\ContentManagementSystemBundle\Services\CMSService::__construct($templateEngine, $em)

CMSService constructor.



* Visibility: **public**


#### Arguments
* $templateEngine **mixed**
* $em **mixed** - &lt;p&gt;EntityManagerInterface&lt;/p&gt;



### getTemplateEngine

    mixed cjohnson\ContentManagementSystemBundle\Services\CMSService::getTemplateEngine()

Get the configured template engine (Twig usually)



* Visibility: **private**




### setTemplateEngine

    mixed cjohnson\ContentManagementSystemBundle\Services\CMSService::setTemplateEngine(mixed $templateEngine)

Set the template engine



* Visibility: **private**


#### Arguments
* $templateEngine **mixed**



### getPageContents

    string cjohnson\ContentManagementSystemBundle\Services\CMSService::getPageContents($page)

Use this to get the HTML content of the page, useful when you want to embed the CMS content inside other content.



* Visibility: **public**


#### Arguments
* $page **mixed** - &lt;p&gt;A page object or null&lt;/p&gt;



### getPageResponse

    \Symfony\Component\HttpFoundation\Response cjohnson\ContentManagementSystemBundle\Services\CMSService::getPageResponse($page)

Use this when you want to render a Response from the CMS



* Visibility: **public**


#### Arguments
* $page **mixed** - &lt;p&gt;A page object or null&lt;/p&gt;



### getPageByName

    \cjohnson\ContentManagementSystemBundle\Entity\Page cjohnson\ContentManagementSystemBundle\Services\CMSService::getPageByName(string $name)

Use this to get a page by its name!



* Visibility: **public**


#### Arguments
* $name **string** - &lt;p&gt;The name of the page as created in the admin UI&lt;/p&gt;



### getPageByUri

    \cjohnson\ContentManagementSystemBundle\Entity\Page cjohnson\ContentManagementSystemBundle\Services\CMSService::getPageByUri(string $uri)

Use this to get a page by its URI/Slug



* Visibility: **public**


#### Arguments
* $uri **string** - &lt;p&gt;The URI of the page as specified in the admin UI&lt;/p&gt;



### getPageRowsAndComponents

    array cjohnson\ContentManagementSystemBundle\Services\CMSService::getPageRowsAndComponents(\cjohnson\ContentManagementSystemBundle\Entity\Page $page)

This gets all the Page Rows and Components for a given page



* Visibility: **private**


#### Arguments
* $page **cjohnson\ContentManagementSystemBundle\Entity\Page**



### getEntityManager

    \Doctrine\ORM\EntityManagerInterface cjohnson\ContentManagementSystemBundle\Services\CMSService::getEntityManager()

Get the doctringe entity manager



* Visibility: **public**




### setEntityManager

    mixed cjohnson\ContentManagementSystemBundle\Services\CMSService::setEntityManager(\Doctrine\ORM\EntityManagerInterface $entityManager)

Set the doctrine entity manager



* Visibility: **public**


#### Arguments
* $entityManager **Doctrine\ORM\EntityManagerInterface**


