CRUDlexSymfony4Bundle
=====================

This bundle provides the integration of CRUDlex in a symfony 4 project.

## Installation

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require philiplb/crudlexsymfony4bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require philiplb/crudlexsymfony4bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

#### Step 2: Enable the Bundle

Add the bundle to your `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...
    philiplb\CRUDlexSymfony4Bundle\CRUDlexSymfony4Bundle::class => ['all' => true],
    //...
];

```

Or, depending on your setup, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new philiplb\CRUDlexSymfony4Bundle\CRUDlexSymfony4Bundle(),
        );

        // ...
    }

    // ...
}
```

#### Step 3: Add the Routes

CRUDlex brings some routes so they must be added to your `config/routes.yaml`. This makes them available under /crud:

```yaml
crudlex:
    resource: '@CRUDlexSymfony4Bundle/Resources/config/routes.yaml'
    prefix: /crud
```

#### Step 4: Configure the Services to your Requirements

CRUDlexSymfony4Bundle is basically a chunk of services. Some configuration like the location of the crud.yml happens
here. You can override each service in order to fit your requirements with the `config/services.yaml`. Here is the
complete configuration to pick from:

```yaml
services:
    crudlex.dataFactoryInterface:
        public: true
        class: "CRUDlex\\MySQLDataFactory"
        arguments:
          - "@doctrine.dbal.default_connection"
    crudlex.entityDefinitionFactoryInterface:
        public: true
        class: "CRUDlex\\EntityDefinitionFactory"
    crudlex.fileSystemAdapter:
        public: true
        class: "League\\Flysystem\\Adapter\\Local"
        arguments:
          - "%kernel.project_dir%/var"
    crudlex.fileSystem:
        public: true
        class: "League\\Flysystem\\Filesystem"
        arguments:
          - "@crudlex.fileSystemAdapter"
    crudlex.entityDefinitionValidatorInterface:
        public: true
        class: "CRUDlex\\EntityDefinitionValidator"
    crudlex.service:
        public: true
        class: "CRUDlex\\Service"
        arguments:
          - "%kernel.project_dir%/config/crud.yml"
          - "%kernel.cache_dir%"
          - "@Symfony\\Component\\Routing\\Generator\\UrlGeneratorInterface"
          - "@translator"
          - "@crudlex.dataFactoryInterface"
          - "@crudlex.entityDefinitionFactoryInterface"
          - "@crudlex.fileSystem"
          - "@crudlex.entityDefinitionValidatorInterface"
    CRUDlex\Controller:
        public: true
        class: "CRUDlex\\Controller"
        arguments:
          - "@crudlex.service"
          - "@crudlex.fileSystem"
          - "@twig"
          - "@session"
          - "@translator"
    kernel.listener.crudlex:
        class: philiplb\CRUDlexSymfony4Bundle\EventListener\RequestListener
        tags:
            - { name: kernel.event_listener, event: kernel.request, method: onKernelRequest }
        arguments:
          - "@crudlex.service"
          - "@session"
          - "@translator"
    crudlex.twigExtensions:
        class: "philiplb\\CRUDlexSymfony4Bundle\\Twig\\CRUDlexExtension"
        tags: ["twig.extension"]
        arguments:
          - "@request_stack"
          - "@session"
```
