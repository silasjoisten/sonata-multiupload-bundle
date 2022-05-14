<?php

declare(strict_types=1);

namespace SilasJoisten\Sonata\MultiUploadBundle\Controller;

use OskarStark\Symfony\Http\Responder;
use SilasJoisten\Sonata\MultiUploadBundle\Form\MultiUploadType;
use Sonata\Doctrine\Model\ManagerInterface;
use Sonata\MediaBundle\Admin\ORM\MediaAdmin;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MultiUploadController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private ManagerInterface $mediaManager,
        private MediaAdmin $mediaAdmin,
        private Pool $mediaProviderPool,
        private Responder $responder,
        private int $maxUploadSize,
        private string $redirectTo,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $this->mediaAdmin->checkAccess('create');

        $providerName = $request->query->get('provider');
        $context = $request->query->get('context', 'default');

        $provider = $this->mediaProviderPool->getProvider($providerName);

        $form = $this->createMultiUploadForm($provider, $context);
        if (!$request->files->has('file')) {
            return $this->responder->render('@SonataMultiUpload/multi_upload.html.twig', [
                'action' => 'multi_upload',
                'form' => $form->createView(),
                'provider' => $provider,
                'maxUploadFilesize' => $this->maxUploadSize,
                'redirectTo' => $this->redirectTo,
            ]);
        }

        /** @var MediaInterface $media */
        $media = $this->mediaManager->create();
        $media->setContext($context);
        $media->setBinaryContent($request->files->get('file'));
        $media->setProviderName($providerName);
        $this->mediaManager->save($media);

        return $this->responder->json([
            'status' => 'ok',
            'path' => $provider->generatePublicUrl($media, MediaProviderInterface::FORMAT_ADMIN),
            'edit' => $this->mediaAdmin->generateUrl('edit', ['id' => $media->getId()]),
            'id' => $media->getId(),
        ]);
    }

    private function createMultiUploadForm(MediaProviderInterface $provider, string $context): FormInterface
    {
        return $this->formFactory->create(MultiUploadType::class, null, [
            'data_class' => $this->mediaManager->getClass(),
            'action' => $this->mediaAdmin->generateUrl('multi_upload', ['provider' => $provider->getName()]),
            'provider' => $provider->getName(),
            'context' => $context,
        ]);
    }
}
