<?php

namespace philiplb\CRUDlexSymfony4Bundle;

use CRUDlex\Service;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class CRUDlexSymfony4Bundle extends Bundle
{

    /**
     * Setups the templates.
     */
    protected function setupTemplates()
    {
        $this->container->get('twig')->getLoader()->addPath(__DIR__.'/../CRUDlex/src/views/', 'crud');
    }

    /**
     * Setups the available locales.
     */
    protected function setupLocales()
    {
        $translator = $this->container->get('translator');
        $locales   = Service::getLocales();
        $localeDir = __DIR__.'/../CRUDlex/src/locales';
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
