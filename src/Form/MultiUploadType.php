<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('context', HiddenType::class, ['data' => $options['context'] ?? 'default'])
            ->add('providerName', HiddenType::class, ['data' => $options['provider']])
            ->add('binaryContent', FileType::class, ['attr' => ['multiple' => true]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '',
            'provider' => '',
            'context' => 'default',
        ]);
    }

    public function getName()
    {
        return self::class;
    }
}
