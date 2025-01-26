<?php namespace x\art;

function content($content) {
    if (!$content) {
        return $content;
    }
    \extract(\lot(), \EXTR_SKIP);
    if (empty($page)) {
        return $content;
    }
    // Append custom CSS before `</head>`
    $content = \strtr($content, ['</head>' => $page->style . '</head>']);
    // Append custom JS before `</body>`
    $content = \strtr($content, ['</body>' => $page->script . '</body>']);
    return $content;
}

function page__script($script) {
    if ("" === ($script = \trim($script ?? ""))) {
        return null;
    }
    if (
        false === \strpos($script, '</script>') &&
        false === \strpos($script, '<script ') &&
        false === \strpos($script, "<script\n") &&
        false === \strpos($script, "<script\r") &&
        false === \strpos($script, "<script\t")
    ) {
        return '<script>' . $script . '</script>';
    }
    return $script;
}

function page__style($style) {
    if ("" === ($style = \trim($style ?? ""))) {
        return null;
    }
    if (
        false === \strpos($style, '</style>') &&
        false === \strpos($style, '<link ') &&
        false === \strpos($style, "<link\n") &&
        false === \strpos($style, "<link\r") &&
        false === \strpos($style, "<link\t")
    ) {
        return '<style media="screen">' . $style . '</style>';
    }
    return $style;
}

function route__page($content, $path) {
    \extract(\lot(), \EXTR_SKIP);
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
    \Hook::set('page.script', __NAMESPACE__ . "\\page__script", 2);
    \Hook::set('page.style', __NAMESPACE__ . "\\page__style", 2);
    \Hook::set('route.page', __NAMESPACE__ . "\\route__page", 0);
}