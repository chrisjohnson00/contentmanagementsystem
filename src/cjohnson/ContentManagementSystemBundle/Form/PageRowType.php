<?php

namespace cjohnson\ContentManagementSystemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageRowType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page', 'hidden_entity', array(
                'class' => 'cjohnsonContentManagementSystemBundle:Page',
            ))
            ->add('row', 'entity', array(
                'class'    => 'cjohnsonContentManagementSystemBundle:Row',
                'property' => 'name',
                'label'    => 'Row Name'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class' => 'cjohnson\ContentManagementSystemBundle\Entity\PageRow'
                               ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cjohnson_contentmanagementsystembundle_pagerow';
    }
}
