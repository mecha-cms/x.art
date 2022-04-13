<?php

namespace x {
    function art($content) {
        if (empty($content)) {
            return $content;
        }
        \extract($GLOBALS, \EXTR_SKIP);
        if (empty($page)) {
            return $content;
        }
        // Append custom CSS before `</head>`
        $content = \strtr($content, ['</head>' => $page->css . '</head>']);
        // Append custom JS before `</body>`
        $content = \strtr($content, ['</body>' => $page->js . '</body>']);
        return $content;
    }
}

namespace x\art {
    function css($content) {
        $content = \trim($content ?? "");
        if ($content && false === \strpos($content, '</style>') && false === \strpos($content, '<link ')) {
            return '<style media="screen">' . $content . '</style>';
        }
        return $content;
    }
    function js($content) {
        $content = \trim($content ?? "");
        if ($content && false === \strpos($content, '</script>') && false === \strpos($content, '<script ')) {
            return '<script>' . $content . '</script>';
        }
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
            $css = $page['css'];
            $js = $page['js'];
            \State::set([
                'has' => [
                    'css' => !!$css,
                    'js' => !!$js
                ],
                'is' => ['art' => $css || $js],
                'not' => ['art' => !$css && !$js]
            ]);
        }
    }
    // Temporarily disable art page by adding query string `?art=false` in URL
    if (!\array_key_exists('art', $_GET) || !empty($_GET['art'])) {
        \Hook::set('content', __NAMESPACE__, 1);
        \Hook::set('page.css', __NAMESPACE__ . "\\css", 2);
        \Hook::set('page.js', __NAMESPACE__ . "\\js", 2);
        \Hook::set('route.page', __NAMESPACE__ . "\\route", 0);
    }
}