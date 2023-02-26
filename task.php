<?php

if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['x']['art'])) {
    if (defined('TEST') && TEST) {
        status(200);
        type('text/plain');
        if (1 === $_POST['x']['art']) {
            foreach ($_POST['files'] as $v) {
                echo 'Rename ' . strtr($v, [PATH . D => '.' . D]) . ' to ' . dirname(strtr($v, [PATH . D => '.' . D])) . D . ('js' === basename($v, '.data') ? 'script' : 'style') . '.data' . "\n";
            }
        } else {
            echo 'Delete ' . strtr(__FILE__, [PATH . D => '.' . D]);
        }
        exit;
    }
    if (1 === $_POST['x']['art']) {
        foreach ($_POST['files'] as $v) {
            rename($v, dirname($v) . D . ('js' === basename($v, '.data') ? 'script' : 'style') . '.data');
        }
    } else {
        unlink(__FILE__);
    }
    kick('/');
}

$files = y(g(LOT . D . 'page', function ($v) {
    $n = basename($v, '.data');
    return 'css' === $n || 'js' === $n;
}, true));

if ($count = count($files)) {
    status(200);
    type('text/html');
    echo '<!DOCTYPE html>';
    echo '<html dir="ltr">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<title>Art</title>';
    echo '</head>';
    echo '<body style="max-width: 600px; margin-right: auto; margin-left: auto;">';
    echo '<form method="post">';
    echo '<p>';
    echo i('Starting from <a href="https://github.com/mecha-cms/x.art" target="_blank">@mecha-cms/x.art</a> version 3.0.0, you will no longer use <code>css.data</code> file to store custom <abbr title="Cascading Style Sheet">CSS</abbr> data and <code>js.data</code> file to store custom <abbr title="JavaScript">JS</abbr> data.');
    echo ' ';
    echo i('You need to rename <code>css.data</code> to <code>style.data</code> and <code>js.data</code> to <code>script.data</code> to migrate to the new version.');
    echo '</p>';
    echo '<p>';
    echo i('Please click the <em>Convert</em> button to rename the files automatically or click the <em>Cancel</em> button to remove this message and rename the files manually.');
    echo '</p>';
    echo '<p>';
    foreach ($files as $k => $v) {
        echo '<label style="display: block;">';
        echo '<input checked name="files[]" type="checkbox" value="' . $k . '">';
        echo '&nbsp;';
        echo '<code>' . strtr($k, [PATH . D => '.' . D]) . '</code>';
        echo '</label>';
    }
    echo '</p>';
    echo '<p>';
    echo '<button name="x[art]" title="' . eat('Accept and convert all marked files!') . '" type="submit" value="1">';
    echo i('Convert');
    echo '</button>';
    echo '&nbsp;';
    echo '<button name="x[art]" title="' . eat('Let me convert the files one by one manually!') . '" type="submit" value="0">';
    echo i('Cancel');
    echo '</button>';
    echo '</p>';
    echo '</form>';
    echo '</body>';
    echo '</html>';
    exit;
}

if (defined('TEST') && TEST) {
    status(200);
    type('text/plain');
    echo 'Delete ' . strtr(__FILE__, [PATH . D => '.' . D]);
    exit;
}

unlink(__FILE__);