<?php

namespace cjohnson\ContentManagementSystemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class'      => 'tinymce',
                    'data-theme' => 'full' // Skip it if you want to use default theme
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cjohnson\ContentManagementSystemBundle\Entity\Component'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cjohnson_contentmanagementsystembundle_component';
    }
}
