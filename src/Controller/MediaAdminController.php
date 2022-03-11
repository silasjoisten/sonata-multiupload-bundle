<?php

declare(strict_types=1);

namespace SilasJoisten\Sonata\MultiUploadBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @phpstan-extends CRUDController<\Sonata\MediaBundle\Model\MediaInterface>
 */
final class MediaAdminController extends CRUDController
{
    public function createAction(Request $request): Response
    {
        $this->admin->checkAccess('create');

        if (null === $request->get('provider') && $request->isMethod('get')) {
            $pool = $this->container->get('sonata.media.pool');
            \assert($pool instanceof Pool);

            $this->renderWithExtraParams('@SonataMultiUpload/select_provider.html.twig', [
                'providers' => $pool->getProvidersByContext(
                    $request->get('context', $pool->getDefaultContext())
                ),
                'action' => 'create',
            ]);
        }

        return parent::createAction($request);
    }
}
