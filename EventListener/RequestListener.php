<?php

/*
 * This file is part of the CRUDlexSymfony4Bundle package.
 *
 * (c) Philip Lehmann-Böhm <philip@philiplb.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace philiplb\CRUDlexSymfony4Bundle\EventListener;

use CRUDlex\Service;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Translation\TranslatorInterface;

class RequestListener
{

    private $service;

    private $session;

    private $translator;

    public function __construct(Service $service, SessionInterface $session, TranslatorInterface $translator)
    {
        $this->service = $service;
        $this->session = $session;
        $this->translator = $translator;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $manageI18n = $this->service->isManageI18n();
        if ($manageI18n) {
            $locale = $this->session->get('locale', 'en');;
            $this->service->setLocale($locale);
            $this->translator->setLocale($locale);
        }

        // Reset them as the locale is unknown in the constructor when they were first set.
        $standardFieldLabels = [
            'id' => $this->translator->trans('crudlex.label.id'),
            'created_at' => $this->translator->trans('crudlex.label.created_at'),
            'updated_at' => $this->translator->trans('crudlex.label.updated_at')
        ];
        foreach ($this->service->getEntities() as $entity) {
            $this->service->getData($entity)->getDefinition()->setStandardFieldLabels($standardFieldLabels);
        }
    }
}
