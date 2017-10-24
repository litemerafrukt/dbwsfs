<?php

/**
 * Setup layout for all routes
 */
return [
    "routes" => [
        [
            "info" => "Setup layout",
            "requestMethod" => null,
            "path" => "**",
            "callable" => ["layoutController", "setup"]
        ],
        [
            "info" => "Setup toptags",
            "requestMethod" => null,
            "path" => "**",
            "callable" => ["tagsController", "toptags"]
        ],
    ]
];
