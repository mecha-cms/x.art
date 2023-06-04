<?php

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    // Disable art page in control panel
    Hook::let('content', "x\\art\\content");
    Hook::set('_', function ($_) {
        if (0 === strpos($_['type'] . '/', 'page/page/') && !empty($_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'])) {
            extract($GLOBALS, EXTR_SKIP);
            $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['art'] = array_replace_recursive([
                'lot' => [
                    'fields' => [
                        'lot' => [
                            'script' => [
                                'height' => true,
                                'hint' => ['%s goes here...', 'JS'],
                                'name' => 'data[script]',
                                'stack' => 20,
                                'state' => [
                                    'source' => ['type' => 'JavaScript'],
                                    'tab' => '    '
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
                                    'source' => ['type' => 'CSS'],
                                    'tab' => '  '
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
        }
        return $_;
    }, 20);
}