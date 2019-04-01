<?php

namespace SilasJoisten\Sonata\MultiUploadBundle\Controller;

use SilasJoisten\Sonata\MultiUploadBundle\Form\MultiUploadType;
use Sonata\Doctrine\Model\ManagerInterface;
use Sonata\MediaBundle\Controller\MediaAdminController;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @codeCoverageIgnore
 */
class MultiUploadController extends MediaAdminController
{
    /**
     * @var ManagerInterface
     */
    private $mediaManager;

    public function __construct(ManagerInterface $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    public function createAction(Request $request = null)
    {
        $this->admin->checkAccess('create');

        if (!$request->get('provider') && $request->isMethod('get')) {
            $pool = $this->get('sonata.media.pool');

            return $this->render('@SonataMultiUpload/select_provider.html.twig', [
                'providers' => $pool->getProvidersByContext(
                    $request->get('context', $pool->getDefaultContext())
                ),
                'action' => 'create',
            ]);
        }

        return parent::createAction($request);
    }

    public function multiUploadAction(Request $request)
    {
        $this->admin->checkAccess('create');

        $providerName = $request->query->get('provider');
        $context = $request->query->get('context', 'default');

        /** @var MediaProviderInterface $provider */
        $provider = $this->get($providerName);

        $form = $this->createMultiUploadForm($provider, $context);
        if (!$request->files->has('file')) {
            return $this->render('@SonataMultiUpload/multi_upload.html.twig', [
                'action' => 'multi_upload',
                'form' => $form->createView(),
                'provider' => $provider,
                'maxUploadFilesize' => $this->container->getParameter('sonata_multi_upload.max_upload_filesize'),
                'redirectTo' => $this->container->getParameter('sonata_multi_upload.redirect_to'),
            ]);
        }

        /** @var MediaInterface $media */
        $media = $this->mediaManager->create();
        $media->setContext($context);
        $media->setBinaryContent($request->files->get('file'));
        $media->setProviderName($providerName);
        $this->mediaManager->save($media);

        return new JsonResponse([
            'status' => 'ok',
            'path' => $provider->generatePublicUrl($media, MediaProviderInterface::FORMAT_ADMIN),
            'edit' => $this->admin->generateUrl('edit', ['id' => $media->getId()]),
            'id' => $media->getId(),
        ]);
    }

    private function createMultiUploadForm(MediaProviderInterface $provider, string $context): FormInterface
    {
        return $this->createForm(MultiUploadType::class, null, [
            'data_class' => $this->mediaManager->getClass(),
            'action' => $this->admin->generateUrl('multi_upload', ['provider' => $provider->getName()]),
            'provider' => $provider->getName(),
            'context' => $context,
        ]);
    }
}
