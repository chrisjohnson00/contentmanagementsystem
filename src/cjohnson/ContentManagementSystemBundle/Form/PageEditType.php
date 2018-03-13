<?php

namespace cjohnson\ContentManagementSystemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('uri')
            ->add('isHomePage', null, array('required' => false, 'label' => 'Use as home page'))
            ->add('hideHeader', null, array('required' => false, 'label' => 'Hide the page title/header'))
            ->add('cacheTTL', "choice", array('choices' => array('0'       => 'None', '60' => 'One Minute', '300' => 'Five Minutes',
                                                                 '900'     => 'Fifteen Minutes', '3600' => 'One Hour',
                                                                 '86400'   => 'One Day', '604800' => 'One Week',
                                                                 '2592000' => 'One Month', '31104000' => 'One Year'
                            )
                            )
            )
            ->add('published', 'checkbox', array(
                'label'    => 'Show this page publicly?',
                'required' => false,
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class' => 'cjohnson\ContentManagementSystemBundle\Entity\Page'
                               ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cjohnson_contentmanagementsystembundle_page_edit';
    }
}
