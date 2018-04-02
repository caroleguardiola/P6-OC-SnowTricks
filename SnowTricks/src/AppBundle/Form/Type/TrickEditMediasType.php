<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickEditMediasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', CollectionType::class, array(
                'entry_type' => ImageType::class,
                'allow_add' =>  true,
                'allow_delete'  => true,
                'required' => false,
                'by_reference' => false
            ))
            ->add('videos', CollectionType::class, array(
                'entry_type' => VideoType::class,
                'allow_add' =>  true,
                'allow_delete'  => true,
                'required' => false,
                'by_reference' => false
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Trick'
        ));
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_trick';
    }
}
