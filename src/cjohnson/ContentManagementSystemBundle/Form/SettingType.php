<?php

namespace cjohnson\ContentManagementSystemBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SettingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bootstrapVersion')
            ->add('bootswatchTemplate', ChoiceType::class, array(
                'choices' => array(
                    'Default'   => 'Default',
                    'Cerulean'  => 'Cerulean',
                    'Cosmo'     => 'Cosmo',
                    'Cyborg'    => 'Cyborg',
                    'Darkly'    => 'Darkly',
                    'Flatly'    => 'Flatly',
                    'Journal'   => 'Journal',
                    'Lumen'     => 'Lumen',
                    'Paper'     => 'Paper',
                    'Readable'  => 'Readable',
                    'Sandstone' => 'Sandstone',
                    'Simplex'   => 'Simplex',
                    'Slate'     => 'Slate',
                    'Spacelab'  => 'Spacelab',
                    'Superhero' => 'Superhero',
                    'United'    => 'United',
                    'Yeti'      => 'Yeti',
                ), 'attr' => array('class' => 'templateName'),
            ))
            ->add('jqueryVersion');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                                   'data_class' => 'cjohnson\ContentManagementSystemBundle\Entity\Setting'
                               ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cjohnson_contentmanagementsystembundle_setting';
    }
}
