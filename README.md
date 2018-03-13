Content Management System Bundle
==========

A Symfony project created on May 24, 2015, 11:59 am.


# Installation #

## Update your composer ##
Manually add `"wowguild/contentmanagementbundle": "dev-master"` to your require section

as well as add this section
        "repositories": [
            {
                "type": "vcs",
                "url": "https://wowguild@bitbucket.org/wowguild/contentmanagementbundle.git"
            }
        ]

## Add to your AppKernel.php ##
            new cjohnson\ContentManagementSystemBundle\cjohnsonContentManagementSystemBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Presta\SitemapBundle\PrestaSitemapBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),

## Add to your config.yml ##
    stof_doctrine_extensions:
        default_locale: en
        orm:
            default:
                sluggable: true
                softdeleteable: true

    doctrine:
        orm:
            entity_managers:
                default:
                    filters:
                        softdeleteable:
                            class: Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter
                            enabled: true
                    auto_mapping: true

    stfalcon_tinymce:
        include_jquery: false
        tinymce_jquery: true
        theme:
            # Simple theme: same as default theme
            simple: ~
            # Admin theme with all enabled plugins
            full:
                plugins:
                   - "advlist autolink lists link image charmap print preview hr anchor pagebreak"
                   - "searchreplace wordcount visualblocks visualchars code fullscreen"
                   - "insertdatetime media nonbreaking save table contextmenu directionality"
                   - "emoticons template paste textcolor"
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                toolbar2: "print preview media | forecolor backcolor emoticons | stfalcon | example"
                image_advtab: true
                height: 500

    twig:
        form:
            #resources: ['bootstrap_3_layout.html.twig']
            resources: ['bootstrap_3_horizontal_layout.html.twig']

    framework:
        translator: { fallbacks: [en] }
        esi: { enabled: true }
        fragments: { path: /_fragment }

    services:
        lrotherfield.form.type.hidden_entity:
            class: Lrotherfield\Component\Form\Type\HiddenEntityType
            arguments:
                - @doctrine.orm.entity_manager
            tags:
                - { name: form.type, alias: hidden_entity }
                
    vich_uploader:
        db_driver: orm # or mongodb or propel or phpcr
        mappings:
            cms_image:
                uri_prefix:         /images/cms
                upload_destination: %kernel.root_dir%/../web/images/cms
    
    liip_imagine:
        filter_sets:
            imagePreview:
                filters:
                    thumbnail: { size: [150, 150], mode: inset }
            imageDetail:
                filters:
                    thumbnail: { size: [500, 500], mode: inset }


## Add to routing ##

    _liip_imagine:
        resource: "@LiipImagineBundle/Resources/config/routing.xml"

    cjohnson_content_management_system:
        resource: "@cjohnsonContentManagementSystemBundle/Resources/config/routing.xml"
        prefix:   /

## Add to security ##
        - { path: ^/admin/cms/, role: ROLE_ADMIN }

## Instal DB ##
`php app/console doctrine:schema:update --force --dump-sql`

## Instal Assets ##
`php app/console asset:install`

## Enabling the sitemap ##
Add the following to your routing file to enable the sitemap.xml via Presta Sitemap Bundle

    PrestaSitemapBundle:
        resource: "@PrestaSitemapBundle/Resources/config/routing.yml"
        prefix:   /
        
## Image config ##
Make sure you have a web/images/cms directory that is writable by apache

## Navigation Header Config ##
Where ever you want the admin header to appear, place this tag

    {{ render_esi(controller('cjohnsonContentManagementSystemBundle:Default:header')) }}

Feel free to override the provided template by copying the bundle template to app/Resources/cjohnsonContentManagementSystemBundle/views/Default/header.html.twig and making any modifications

## Bootstrap Templating & Jquery Version Administration ##
You can control the template used with bootstrap (provided by bootswatch) as well as manage the version of bootstrap & jquery from the admin interface.  In order to actually use these configurations, you'll need to add these tags to your base template.  Until you define specific versions and templates, 3.3.6 will be used with the default bootstrap template.

in the html -> head

    {{ render(controller('cjohnsonContentManagementSystemBundle:Setting:header')) }}

right before html -> close body

    {{ render(controller('cjohnsonContentManagementSystemBundle:Setting:footer')) }}

## Using the CMS service in your project ##
You can use the CMS without using the bundled templates if you want more control over the look/feel than provided by the bundle, or if you only want to use the CMS on a subset of your site's pages.

Here's an example

### In The Controller ###
    /**
    * @var $cms CMSService
    */
    $cms = $this->get('cjohnson.contentManagementSystemBundle');
    $page = $cms->getPageByUri("calendar");
    $content = $cms->getPageContents($page);
    
    return array('content' => $content);

### In The Template ###

    {{ content|raw }}
            
The service offers a few different accessors and ways to get pages and the resulting content, you can find the phpdocs for this in src/cjohnson/ContentManagementSystemBundle/Resources/doc.
To generate a new version of this doc run 

    php /vagrant/vendor/phpdocumentor/phpdocumentor/bin/phpdoc --target /tmp/ --template="xml" --filename /vagrant/src/cjohnson/ContentManagementSystemBundle/Services/CMSService.php
    /vagrant/vendor/evert/phpdoc-md/bin/phpdocmd /tmp/structure.xml /vagrant/src/cjohnson/ContentManagementSystemBundle/Resources/doc