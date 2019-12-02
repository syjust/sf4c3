<?php

namespace App\Twig\Extension;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('i18n_link', [$this, 'generateLink'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('i18n_links', [$this, 'generateLinks'], ['is_safe' => ['html']]),
        ];
    }

    public function generateLink(string $label, string $locale, string $routeName): string
    {
        $url = $this->router->generate($routeName, array('_locale' => $locale));

        return sprintf('<a href="%s">%s</a>', $url, $label);
    }

    public function generateLinks(array $locales, string $routeName): string
    {
        $labels = ['en' => 'English', 'fr' => 'French', 'de' => 'German'];
        $html = '';

        foreach ($locales as $locale) {
            $label = $labels[$locale];
            $html .= '<li>'.$this->generateLink($label, $locale, $routeName).'</li>';
        }

        return $html;
    }
}
