<?php

/*
 * This file is part of the CRUDlexSymfony4Bundle package.
 *
 * (c) Philip Lehmann-Böhm <philip@philiplb.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace philiplb\CRUDlexSymfony4Bundle\Twig;

use CRUDlex\TwigExtensions;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CRUDlexExtension, registers the CRUDlex Twig extensions.
 * @package philiplb\CRUDlexSymfony4Bundle\Twig
 */
class CRUDlexExtension extends AbstractExtension
{

    /**
     * Hold the current request stack.
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Holds the current session instance.
     * @var SessionInterface
     */
    protected $session;

    /**
     * CRUDlexExtension constructor.
     *
     * @param RequestStack $requestStack
     * the current request stack
     *
     * @param SessionInterface $session
     * the current session instance
     */
    public function __construct(RequestStack $requestStack, SessionInterface $session)
    {
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $twigExtensions = new TwigExtensions();
        return [
            new TwigFilter('crudlex_arrayColumn', 'array_column'),
            new TwigFilter('crudlex_languageName', [$twigExtensions, 'getLanguageName']),
            new TwigFilter('crudlex_float', [$twigExtensions, 'formatFloat']),
            new TwigFilter('crudlex_basename', 'basename'),
            new TwigFilter('crudlex_formatDate', [$twigExtensions, 'formatDate']),
            new TwigFilter('crudlex_formatDateTime', [$twigExtensions, 'formatDateTime'])
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $requestStack = $this->requestStack;
        $session = $this->session;
        return [
            new TwigFunction('crudlex_getCurrentUri', function() use ($requestStack) {
                return $requestStack->getCurrentRequest()->getUri();
            }),
            new TwigFunction('crudlex_sessionGet', function($name, $default) use ($session) {
                return $session->get($name, $default);
            }),
            new TwigFunction('crudlex_sessionFlashBagGet', function($type) use ($session) {
                return $session->getFlashBag()->get($type);
            })
        ];
    }
}