<?php
/**
 * Routes to ease development and debugging.
 */
return [
    "routes" => [
        [
            "info" => "Debug and information.",
            "requestMethod" => null,
            "path" => "info",
            "callable" => ["debugController", "info"],
        ],
    ]
];
