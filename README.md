Installation
============

### Step 1: Download the Bundle

```console
$ composer require silasjoisten/sonata-multiupload-bundle
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

First you need to override the default `MediaAdminController.php` set following in your `config/services.yaml`

```yaml
parameters:
    sonata.media.admin.media.controller: SilasJoisten\Sonata\MultiUploadBundle\Controller\MultiUploadController

services:
    #...
```

Now add to the service definition of your Provider and add to tag `multi_upload: true` like:

```yaml

App\Provider\VideoProvider:
    arguments:
        - "App\Provider\VideoProvider"
        # ...
    calls:
        # ...
    tags:
        - { name: sonata.media.provider, multi_upload: true }

```

After That you need to add the dependency to your `config/packages/sonata_admin.yaml`:
```yaml
sonata_admin:
    assets:
        extra_stylesheets:
            - bundles/sonatamultiupload/libs/uploader/css/jquery.dm-uploader.min.css


        extra_javascripts:
            - bundles/sonatamultiupload/libs/uploader/js/jquery.dm-uploader.min.js
```

Thats it!

**Notice that the uploader won't work for Providers like: YouTubeProvider, VimeoProvider!**

### 4. Look & Feel

![before_uploading](docs/images/before_uploading.png)
![after_uploading](docs/images/after_uploading.png)

Used Library: 
* [jQuery Upload](https://github.com/danielm/uploader)