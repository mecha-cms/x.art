<?php

// Self-delete after one month…
if (filemtime(__FILE__) < strtotime('-1 month')) {
    unlink(__FILE__);
    return;
}

Hook::set('route.page', function ($content, $path) use ($state) {
    $route = trim($path ?? $state->route ?? 'index', '/');
    if ($f = exist(LOT . D . 'page' . D . $route . D . '{css,js,script,style}.data')) {
        if (!is_dir($d = dirname($f) . D . '+') && !mkdir($d, 0700, true) && !is_dir($d)) {
            throw new RuntimeException('Failed to create folder: `' . $d . '`');
        }
        $n = basename($f, '.data');
        if (!rename($f, $ff = $d . D . ('css' === $n ? 'style' : ('js' === $n ? 'script' : $n)) . '.txt')) {
            throw new RuntimeException('Failed to move file: `' . $f . '`');
        }
        chmod($ff, 0600);
        return $content;
    }
}, 0);