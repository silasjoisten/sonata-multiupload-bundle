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

In your provider where you want to use multiupload you need to add following trait:
`SilasJoisten\Sonata\MultiUploadBundle\Traits\MultiUploadTrait`


After That you need to add the dependency to your `config/packages/sonata_admin.yaml`:
```yaml
sonata_admin:
    assets:
        extra_stylesheets:
            - bundles/sonatamultiupload/dist/sonata-multiupload.css

        extra_javascripts:
            - bundles/sonatamultiupload/dist/sonata-multiupload.js
```

Thats it!

**Notice that the uploader won't work for Providers like: YouTubeProvider, VimeoProvider!**

### 4. Look & Feel

![multiupload](docs/images/multiupload.gif)

Used Library: 
* [jQuery Upload](https://github.com/danielm/uploader)
