<?php

/*
 * This file is part of the CRUDlexSymfony4Bundle package.
 *
 * (c) Philip Lehmann-Böhm <philip@philiplb.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace philiplb\CRUDlexSymfony4Bundle;

use CRUDlex\Service;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Translation\Loader\YamlFileLoader;

/**
 * Class CRUDlexSymfony4Bundle, the bundle defining class.
 * @package philiplb\CRUDlexSymfony4Bundle
 */
class CRUDlexSymfony4Bundle extends Bundle
{

    /**
     * Setups the templates.
     */
    protected function setupTemplates()
    {
        $this->container->get('twig')->getLoader()->addPath(__DIR__.'/../crudlex/src/views/', 'crud');
    }

    /**
     * Setups the available locales.
     */
    protected function setupLocales()
    {
        $translator = $this->container->get('translator');
        $locales   = Service::getLocales();
        $localeDir = __DIR__.'/../crudlex/src/locales';
        $translator->addLoader('yaml', new YamlFileLoader());
        foreach ($locales as $locale) {
            $translator->addResource('yaml', $localeDir.'/'.$locale.'.yml', $locale);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->setupTemplates();
        $this->setupLocales();
    }

}
