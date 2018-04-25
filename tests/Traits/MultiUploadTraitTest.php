<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\Traits;

use PHPUnit\Framework\TestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Traits\MultiUploadTrait;

class MultiUploadTraitTest extends TestCase
{
    /**
     * @dataProvider setterGetterProvider
     */
    public function testSetterGetter($setter, $getter, $value)
    {
        $entity = (new TestMultiUploadTrait())->$setter($value);

        $this->assertEquals($value, $entity->$getter());
    }

    /**
     * @return array
     */
    public function setterGetterProvider()
    {
        return [
            ['setMultiUpload', 'getMultiUpload', true],
            ['setMultiUpload', 'getMultiUpload', false],
        ];
    }
}

class TestMultiUploadTrait
{
    use MultiUploadTrait;
}
