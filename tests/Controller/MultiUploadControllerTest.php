<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use SilasJoisten\Sonata\MultiUploadBundle\Controller\MultiUploadController;
use Sonata\CoreBundle\Model\ManagerInterface;

class MultiUploadControllerTest extends TestCase
{
    private $controller;

    protected function setUp()
    {
        $mediaManager = $this->createMock(ManagerInterface::class);
        $this->controller = new MultiUploadController($mediaManager);
    }

    public function testItIsInstantiable()
    {
        $this->assertNotNull($this->controller);
    }
}
