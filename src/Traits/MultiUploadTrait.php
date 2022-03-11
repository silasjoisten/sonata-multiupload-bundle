<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Traits;

/**
 * @deprecated This Trait is deprecated. SonataMedia provider classes will be final soon. Use sonata_multi_upload.yaml config instead
 */
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
