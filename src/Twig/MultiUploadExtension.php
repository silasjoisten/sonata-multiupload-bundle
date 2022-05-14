<?php

declare(strict_types=1);

namespace SilasJoisten\Sonata\MultiUploadBundle\Twig;

use SilasJoisten\Sonata\MultiUploadBundle\Pool\ProviderChain;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class MultiUploadExtension extends AbstractExtension
{
    private ProviderChain $chain;

    public function __construct(
        ProviderChain $chain
    ) {
        $this->chain = $chain;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_multi_upload_allowed', [$this, 'isMultiUploadAllowed']),
        ];
    }

    public function isMultiUploadAllowed(MediaProviderInterface $provider): bool
    {
        return $this->chain->hasProvider($provider);
    }
}
