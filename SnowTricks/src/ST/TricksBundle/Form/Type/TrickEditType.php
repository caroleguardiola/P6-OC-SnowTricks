<?php

namespace ST\TricksBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
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
            ))
            ->add('category', EntityType::class, array(
                'class' => 'TricksBundle:Category',
                'choice_label' =>  'name',
                'multiple'  => false,
                'expanded'  => false,
                'label' => 'Catégorie'
            ))
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ST\TricksBundle\Entity\Trick'
        ));
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'tricksbundle_trick';
    }
}
