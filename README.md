silasjoisten/sonata-multiupload-bundle
======================================
[![Build Status](https://travis-ci.org/silasjoisten/sonata-multiupload-bundle.svg?branch=master)](https://travis-ci.org/silasjoisten/sonata-multiupload-bundle)
[![Latest Stable Version](https://poser.pugx.org/silasjoisten/sonata-multiupload-bundle/v/stable)](https://packagist.org/packages/silasjoisten/sonata-multiupload-bundle)
[![Total Downloads](https://poser.pugx.org/silasjoisten/sonata-multiupload-bundle/downloads)](https://packagist.org/packages/silasjoisten/sonata-multiupload-bundle)
[![Latest Unstable Version](https://poser.pugx.org/silasjoisten/sonata-multiupload-bundle/v/unstable)](https://packagist.org/packages/silasjoisten/sonata-multiupload-bundle)
[![License](https://poser.pugx.org/silasjoisten/sonata-multiupload-bundle/license)](https://packagist.org/packages/silasjoisten/sonata-multiupload-bundle)
[![codecov](https://codecov.io/gh/silasjoisten/sonata-multiupload-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/silasjoisten/sonata-multiupload-bundle)

## Installation

### Step 1: Download the Bundle

```console
composer require silasjoisten/sonata-multiupload-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new SilasJoisten\Sonata\MultiUploadBundle\SonataMultiUploadBundle(),
        );

        // ...
    }

    // ...
}
```

If you are using flex register bundle in `config/bundles.php`:
```php 
<?php

return [
    //...
    SilasJoisten\Sonata\MultiUploadBundle\SonataMultiUploadBundle::class => ['all' => true]
];
```

### Step 3: Configuration

You have to open the configuration file for this bundle and configure the providers which you want to enable multi upload.
```yaml
# config/packages/sonata_multi_upload.yaml

sonata_multi_upload:
  # ...
  providers:
    - sonata.media.provider.image
    - sonata.media.provider.video

```


Add JavaScript and CSS to SonataAdmin config:
```yaml
# config/packages/sonata_admin.yaml

sonata_admin:
    assets:
        extra_stylesheets:
            - bundles/sonatamultiupload/dist/sonata-multiupload.css

        extra_javascripts:
            - bundles/sonatamultiupload/dist/sonata-multiupload.js
```

#### OPTIONAL

```yaml
# config/packages/sonata_multi_upload.yaml

sonata_multi_upload:
    max_upload_filesize: 3000000 # 3MB the default value is 0 -> allow every size
```

There is an option `redirect_to` which allows you to redirect after complete upload to your configured page.

```yaml
# config/packages/sonata_multi_upload.yaml

sonata_multi_upload:
    redirect_to: 'admin_sonata_media_media_list'
```


**HINT:** The MultiUploadBundle passes automatically the id's from the uploaded `Media` objects 
to the redirection route for example: `/foo/bar?idx=%5B70%2C71%2C72%5D` so you can take them and create 
a gallery from uploaded medias.

### Example: Uploading multiple images and create automatically a `Gallery`

#### Create controller 

The controller takes your request and create in this example a `Gallery` with `GalleryItems` and redirects to the
edit view of `GalleryAdmin`

```php
<?php

namespace App\Controller;

use App\Entity\SonataMediaGallery;
use App\Entity\SonataMediaGalleryItem;
use Sonata\MediaBundle\Admin\GalleryAdmin;
use Sonata\MediaBundle\Entity\MediaManager;
use Sonata\MediaBundle\Entity\GalleryManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateGalleryAction
{
    private MediaManager $mediaManager;
    private GalleryManager $galleryManager;
    private GalleryAdmin $galleryAdmin;

    public function __construct(
        MediaManager   $mediaManager,
        GalleryManager $galleryManager,
        GalleryAdmin   $galleryAdmin
    ) {
        $this->mediaManager = $mediaManager;
        $this->galleryManager = $galleryManager;
        $this->galleryAdmin = $galleryAdmin;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $idx = $request->query->get('idx');
        $idx = json_decode($idx);

        /** @var SonataMediaGallery $gallery */
        $gallery = $this->galleryManager->create();
        $gallery->setName('Auto Created Gallery');
        $gallery->setEnabled(false);
        $gallery->setContext('default');

        foreach ($idx as $id) {
            $media = $this->mediaManager->find($id);

            $galleryHasMedia = new SonataMediaGalleryItem();
            $galleryHasMedia->setGallery($gallery);
            $galleryHasMedia->setMedia($media);
            $gallery->addGalleryItem($galleryHasMedia);
        }

        $this->galleryManager->save($gallery);

        return new RedirectResponse($this->galleryAdmin->generateObjectUrl('edit', $gallery));
    }
}

```

#### Register route

If you already override the default `MediaAdmin` you can add the route in the admin class via
```php
   protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add('create_gallery', 'multi-upload/create-gallery', [
            '_controller' => CreateGalleryAction::class,
        ]);
    }
```

otherwise you can create an `AdminExtension` like the following:
```php
<?php

declare(strict_types=1);

namespace App\Admin\Extension;

use App\Controller\CreateGalleryAction;
use Sonata\AdminBundle\Admin\AbstractAdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

final class MediaAddRouteExtension extends AbstractAdminExtension
{
    public function configureRoutes(AdminInterface $admin, RouteCollectionInterface $collection): void
    {
        $collection->add('create_gallery', 'multi-upload/create-gallery', [
            '_controller' => CreateGalleryAction::class,
        ]);
    }
}

```

and register this extension in your `config/services.yaml`

```yaml
services:
    # ...
    App\Admin\Extension\MediaAddRouteExtension:
        tags:
            - { name: sonata.admin.extension, target: sonata.media.admin.media }
```

Now configure the `redirect_to` in `config/packages/sonata_multi_upload.yaml`

```yaml
sonata_multi_upload:
    redirect_to: 'admin_app_sonatamediamedia_create_gallery'
```

Maybe you need to create an alias for `MediaManager` and `GalleryManager` like:
```yaml
# config/services.yaml
services:
  Sonata\MediaBundle\Entity\MediaManager:
    alias: sonata.media.manager.media

  Sonata\MediaBundle\Entity\GalleryManager:
    alias: sonata.media.manager.gallery

  Sonata\MediaBundle\Admin\GalleryAdmin:
    alias: sonata.media.admin.gallery
```

Thats it.

**Notice that the uploader won't work for Providers like: YouTubeProvider, VimeoProvider!**

### 4. Look & Feel

![multiupload](docs/images/multiupload-bundle.gif)

Used Library: 
* [jQuery Upload](https://github.com/danielm/uploader)
