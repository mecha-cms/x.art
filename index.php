<?php namespace x\art;

function content($content) {
    if (!$content || (false === \strpos($content, '</body>') && false === \strpos($content, '</head>'))) {
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
    if ("" === ($script = \rtrim(\trim($script ?? "", "\n\r")))) {
        return null;
    }
    if (false !== \strpos($script, '</script>') || (false !== ($n = \strpos($script, '<script')) && \strspn($script, " \n\r\t", $n + 7))) {
        return $script;
    }
    return '<script>' . $script . '</script>';
}

function page__style($style) {
    if ("" === ($style = \rtrim(\trim($style ?? "", "\n\r")))) {
        return null;
    }
    if (false !== \strpos($style, '</style>') || (false !== ($n = \strpos($style, '<link')) && \strspn($style, " \n\r\t", $n + 5))) {
        return $style;
    }
    return '<style media="screen">' . $style . '</style>';
}

function route__page($content, $path) {
    \extract(\lot(), \EXTR_SKIP);
    if ($file = \exist(\LOT . \D . 'page' . \D . \trim($path ?? $state->route ?? 'index', '/') . '.{' . \x\page\x() . '}', 1)) {
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