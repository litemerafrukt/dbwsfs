<?php
/**
 * Routes.
 */
return [
    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            //For layout setup
            "mount" => null,
            "file" => __DIR__ . "/route/layout.php",
        ],
        [
            // For debugging and development details on Anax
            "mount" => "debug",
            "file" => __DIR__ . "/route/debug.php",
        ],
        [
            // Home route
            "mount" => null,
            "file" => __DIR__ . "/route/home.php",
        ],
        [
            // Tags route
            "mount" => "tags",
            "file" => __DIR__ . "/route/tags.php",
        ],
        [
            // Routes for posts and questions
            "mount" => "posts",
            "file" => __DIR__ . "/route/posts.php",
        ],
        [
            // Routes for post and question
            "mount" => "post",
            "file" => __DIR__ . "/route/post.php",
        ],
        [
            // Routes for user account managing
            "mount" => "user",
            "file" => __DIR__ . "/route/user.php",
        ],
        [
            // Routes for admin
            "mount" => "admin",
            "file" => __DIR__ . "/route/admin.php",
        ],
        [
            // To read flat file content in Markdown from content/
            "mount" => null,
            "file" => __DIR__ . "/route/flat-file-content.php",
        ],
        [
            // Keep this last since its a catch all
            "mount" => null,
            "file" => __DIR__ . "/route/404.php",
        ],
    ],
];
