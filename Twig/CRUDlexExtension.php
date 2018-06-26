<?php
namespace philiplb\CRUDlexSymfony4Bundle\Twig;

use CRUDlex\TwigExtensions;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CRUDlexExtension extends AbstractExtension
{

    protected $requestStack;

    protected $session;

    public function __construct(RequestStack $requestStack, SessionInterface $session)
    {
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

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