<?php

// Disable art page when in panel
Hook::let('content', "x\\art");

Hook::set('_', function($_) {
    if (0 === strpos($_['type'] . '/', 'page/page/') && !empty($_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot'])) {
        extract($GLOBALS, EXTR_SKIP);
        $_['lot']['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['art'] = array_replace_recursive([
            'lot' => [
                'fields' => [
                    'lot' => [
                        'css' => [
                            'height' => true,
                            'hint' => ['%s goes here...', 'CSS'],
                            'name' => 'data[css]',
                            'stack' => 10,
                            'state' => [
                                'source' => ['type' => 'CSS'],
                                'tab' => '  '
                            ],
                            'title' => '<abbr title="Cascading Style Sheet">CSS</abbr>',
                            'type' => 'source',
                            'value' => $page['css'],
                            'width' => true
                        ],
                        'js' => [
                            'height' => true,
                            'hint' => ['%s goes here...', 'JS'],
                            'name' => 'data[js]',
                            'stack' => 20,
                            'state' => [
                                'source' => ['type' => 'JavaScript'],
                                'tab' => '    '
                            ],
                            'title' => '<abbr title="JavaScript">JS</abbr>',
                            'type' => 'source',
                            'value' => $page['js'],
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