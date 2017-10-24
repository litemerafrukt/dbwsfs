<?php
/**
 * Routes for commenting system.
 */

return [
    "routes" => [
        [
            "info" => "Post main page",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["postsController", "index"]
        ],
        [
            "info" => "Posts for a tag",
            "requestMethod" => "get",
            "path" => "tag/{tag}",
            "callable" => ["postsController", "postsByTag"]
        ],
        [
            "info" => "Only posts",
            "requestMethod" => "get",
            "path" => "p",
            "callable" => ["postsController", "posts"]
        ],
        [
            "info" => "Only questions",
            "requestMethod" => "get",
            "path" => "q",
            "callable" => ["postsController", "questions"]
        ],
    ],
];
