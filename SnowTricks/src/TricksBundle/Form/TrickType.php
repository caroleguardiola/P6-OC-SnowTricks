<?php

namespace TricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCreation',   DateTimeType::class)
            ->add('name',           TextType::class)
            ->add('description',    TextareaType::class)
            ->add('images',         CollectionType::class, array(
                'entry_type' => ImageType::class,
                'allow_add' =>  true,
                'allow_delete'  => true
            ))
            ->add('videos',         CollectionType::class, array(
                'entry_type' => VideoType::class,
                'allow_add' =>  true,
                'allow_delete'  => true
            ))
            ->add('category',       EntityType::class, array(
                'class' => 'TricksBundle:Category',
                'choice_label' =>  'name',
                'multiple'  => false,
                'expanded'  => false
            ))
            ->add('Enregistrer',           SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TricksBundle\Entity\Trick'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tricksbundle_trick';
    }


}
