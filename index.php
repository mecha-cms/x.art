<?php

namespace x\art\page {
    function script($content) {
        if ("" === ($content = \trim($content ?? ""))) {
            return null;
        }
        if (false === \strpos($content, '</script>') && false === \strpos($content, '<script ')) {
            return '<script>' . $content . '</script>';
        }
        return $content;
    }
    function style($content) {
        if ("" === ($content = \trim($content ?? ""))) {
            return null;
        }
        if (false === \strpos($content, '</style>') && false === \strpos($content, '<link ')) {
            return '<style media="screen">' . $content . '</style>';
        }
        return $content;
    }
}

namespace x\art {
    function content($content) {
        if (!$content) {
            return $content;
        }
        \extract($GLOBALS, \EXTR_SKIP);
        if (empty($page)) {
            return $content;
        }
        // Append custom CSS before `</head>`
        $content = \strtr($content, ['</head>' => $page->style . '</head>']);
        // Append custom JS before `</body>`
        $content = \strtr($content, ['</body>' => $page->script . '</body>']);
        return $content;
    }
    function route($content, $path) {
        \extract($GLOBALS, \EXTR_SKIP);
        $folder = \LOT . \D . 'page' . \D . \trim($path ?? $state->route, '/');
        if ($file = \exist([
            $folder . '.archive',
            $folder . '.page'
        ], 1)) {
            $page = new \Page($file);
            $script = $page->script;
            $style = $page->style;
            \State::set([
                'is' => ['art' => $art = $script || $style],
                'not' => ['art' => !$art]
            ]);
        }
    }
    // Temporarily disable art page by adding query string `?art=false` in URL
    if (!\array_key_exists('art', $_GET) || !empty($_GET['art'])) {
        \Hook::set('content', __NAMESPACE__ . "\\content", 1);
        \Hook::set('page.script', __NAMESPACE__ . "\\page\\script", 2);
        \Hook::set('page.style', __NAMESPACE__ . "\\page\\style", 2);
        \Hook::set('route.page', __NAMESPACE__ . "\\route", 0);
    }
}