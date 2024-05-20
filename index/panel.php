<?php namespace x\art;

function _($_) {
    if (0 !== \strpos($_['type'] . '/', 'page/page/') || empty($_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'])) {
        return $_;
    }
    \extract(\lot(), \EXTR_SKIP);
    $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['art'] = \array_replace_recursive([
        'lot' => [
            'fields' => [
                'lot' => [
                    'script' => [
                        'height' => true,
                        'hint' => ['%s goes here...', 'JS'],
                        'name' => 'data[script]',
                        'stack' => 20,
                        'state' => [
                            'tab' => 4,
                            'type' => 'text/javascript'
                        ],
                        'title' => '<abbr title="JavaScript">JS</abbr>',
                        'type' => 'source',
                        'value' => $page['script'],
                        'width' => true
                    ],
                    'style' => [
                        'height' => true,
                        'hint' => ['%s goes here...', 'CSS'],
                        'name' => 'data[style]',
                        'stack' => 10,
                        'state' => [
                            'tab' => 2,
                            'type' => 'text/css'
                        ],
                        'title' => '<abbr title="Cascading Style Sheet">CSS</abbr>',
                        'type' => 'source',
                        'value' => $page['style'],
                        'width' => true
                    ]
                ],
                'type' => 'fields'
            ]
        ],
        'stack' => 30
    ], $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['art'] ?? []);
    return $_;
}

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    \Hook::let('content', "\\x\\art\\content"); // Disable art in control panel
    \Hook::set('_', __NAMESPACE__ . "\\_", 20);
}