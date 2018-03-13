<?php

namespace cjohnson\ContentManagementSystemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeaderLinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sortOrder')
            ->add('linkText')
            ->add('page', 'entity', array(
                'class'    => 'cjohnsonContentManagementSystemBundle:Page',
                'property' => 'name',
                'label'    => 'Page Name'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cjohnson\ContentManagementSystemBundle\Entity\HeaderLink'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cjohnson_contentmanagementsystembundle_headerlink';
    }
}
