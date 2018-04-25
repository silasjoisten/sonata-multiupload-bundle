<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Traits;

trait MultiUploadTrait
{
    /**
     * @var bool
     */
    protected $multiUpload = false;

    public function getMultiUpload(): bool
    {
        return $this->multiUpload;
    }

    public function setMultiUpload(bool $multiUpload): self
    {
        $this->multiUpload = $multiUpload;

        return $this;
    }
}
