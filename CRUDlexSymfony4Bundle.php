<?php

namespace philiplb\CRUDlexSymfony4Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

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
    }

}