<?php

namespace cjohnson\ContentManagementSystemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RowComponentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('row', 'hidden_entity', array(
                'class' => 'cjohnsonContentManagementSystemBundle:Row',
            ))
            ->add('component', 'entity', array(
                'class'    => 'cjohnsonContentManagementSystemBundle:Component',
                'property' => 'name',
                'label'    => 'Component Name'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'cjohnson\ContentManagementSystemBundle\Entity\RowComponent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cjohnson_contentmanagementsystembundle_rowcomponent';
    }
}
