<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Traits;

trait MultiUploadTrait
{
    /**
     * @var bool
     */
    protected $multiUpload = false;

    public function getMultiUpload()
    {
        return $this->multiUpload;
    }

    public function setMultiUpload(bool $multiUpload)
    {
        $this->multiUpload = $multiUpload;

        return $this;
    }
}
