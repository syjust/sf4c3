<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'index', 'path' => '/en', '_controller' => 'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController::urlRedirectAction'], null, null, null, false, false, null]],
        '/auth/check' => [[['_route' => 'login-check'], null, null, null, false, false, null]],
        '/auth/forget' => [[['_route' => 'logout'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/(en|de|fr)(?'
                    .'|(*:21)'
                    .'|/(?'
                        .'|contact(*:39)'
                        .'|game(?'
                            .'|(*:53)'
                            .'|/(?'
                                .'|won(*:67)'
                                .'|failed(*:80)'
                                .'|reset(*:92)'
                                .'|play(?'
                                    .'|/([A-Z])(*:114)'
                                    .'|(*:122)'
                                .')'
                            .')'
                        .')'
                        .'|login(*:138)'
                        .'|register(*:154)'
                    .')'
                .')'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:195)'
                    .'|wdt/([^/]++)(*:215)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:261)'
                            .'|router(*:275)'
                            .'|exception(?'
                                .'|(*:295)'
                                .'|\\.css(*:308)'
                            .')'
                        .')'
                        .'|(*:318)'
                    .')'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        21 => [[['_route' => 'homepage', '_controller' => 'App\\Controller\\DefaultController::index'], ['_locale'], ['GET' => 0], null, true, true, null]],
        39 => [[['_route' => 'contact', '_controller' => 'App\\Controller\\DefaultController::contact'], ['_locale'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        53 => [[['_route' => 'game_home', '_controller' => 'App\\Controller\\GameController::home'], ['_locale'], ['GET' => 0], null, true, false, null]],
        67 => [[['_route' => 'game_won', '_controller' => 'App\\Controller\\GameController::won'], ['_locale'], ['GET' => 0], null, false, false, null]],
        80 => [[['_route' => 'game_failed', '_controller' => 'App\\Controller\\GameController::failed'], ['_locale'], ['GET' => 0], null, false, false, null]],
        92 => [[['_route' => 'game_reset', '_controller' => 'App\\Controller\\GameController::reset'], ['_locale'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        114 => [[['_route' => 'game_play_letter', '_controller' => 'App\\Controller\\GameController::playLetter'], ['_locale', 'letter'], ['GET' => 0], null, false, true, null]],
        122 => [[['_route' => 'game_play_word', '_controller' => 'App\\Controller\\GameController::playWord'], ['_locale'], ['POST' => 0], null, false, false, 1]],
        138 => [[['_route' => 'login', '_controller' => 'App\\Controller\\SecurityController::login'], ['_locale'], ['GET' => 0], null, false, false, null]],
        154 => [[['_route' => 'register', '_controller' => 'App\\Controller\\SecurityController::register'], ['_locale'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        195 => [[['_route' => '_twig_error_test', '_controller' => 'twig.controller.preview_error::previewErrorPageAction', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        215 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        261 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        275 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        295 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        308 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        318 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    static function ($condition, $context, $request) { // $checkCondition
        switch ($condition) {
            case 1: return $request->request->has("word");
        }
    },
];
