<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\Form;

use SilasJoisten\Sonata\MultiUploadBundle\Form\MultiUploadType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiUploadTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        $formBuilder = $this->createMock(FormBuilderInterface::class);
        $formBuilder->expects($this->exactly(3))
            ->method('add')
            ->withConsecutive(
                ['context', HiddenType::class, ['data' => 'default']],
                ['providerName', HiddenType::class, ['data' => 'sonata.media.provider.image']],
                ['binaryContent', FileType::class, ['attr' => ['multiple' => true]]]
            )
            ->willReturnSelf();

        $form = new MultiUploadType();
        $form->buildForm($formBuilder, ['provider' => 'sonata.media.provider.image']);
    }

    public function testConfigureOptions()
    {
        $optionResolver = $this->createMock(OptionsResolver::class);
        $optionResolver->expects($this->once())
            ->method('setDefaults')
            ->with([
                'data_class' => '',
                'provider' => '',
                'context' => 'default',
            ]);

        $form = new MultiUploadType();
        $form->configureOptions($optionResolver);
    }

    protected function getExtensions()
    {
        $childType = new MultiUploadType();

        return [new PreloadedExtension([
            $childType->getName() => $childType,
        ], [])];
    }
}
