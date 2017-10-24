<?php

/**
 * Routes relative to siteUrl
 */

return [
    'routes' => [
        "home" => [
            "label" => 'Alla',
            "route" => "",
        ],
        "posts" => [
            "label" => 'Inlägg',
            "route" => "posts/p",
        ],
        "questions" => [
            "label" => 'Frågor',
            "route" => "posts/q",
        ]
    ]
];
