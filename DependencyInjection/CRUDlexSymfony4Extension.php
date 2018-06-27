<?php

/*
 * This file is part of the CRUDlexSymfony4Bundle package.
 *
 * (c) Philip Lehmann-Böhm <philip@philiplb.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace philiplb\CRUDlexSymfony4Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CRUDlexSymfony4Extension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        //$container->setParameter('crudlex.datafactory', 'CRUDlex\\MySQLDataFactory');
        //$container->setParameter('crudlex.file', '%kernel.project_dir%/crud.yml');
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');
    }
}