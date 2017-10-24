<?php
/**
 * Routes for commenting system.
 */

return [
    "routes" => [
        [
            "info" => "Show a post",
            "requestMethod" => "get|post",
            "path" => "show/{id:digit}",
            "callable" => ["postController", "show"]
        ],
        [
            "info" => "Vote on a post",
            "requestMethod" => "post",
            "path" => "vote/{id:digit}",
            "callable" => ["postController", "vote"]
        ],
        [
            "info" => "Create new post",
            "requestMethod" => "get|post",
            "path" => "new/{type}",
            "callable" => ["postNewEditDeleteController", "new"]
        ],
        [
            "info" => "Delete a post by id",
            "requestMethod" => "get",
            "path" => "delete/{id:digit}",
            "callable" => ["postNewEditDeleteController", "delete"]
        ],
        [
            "info" => "Edit post",
            "requestMethod" => "get|post",
            "path" => "edit/{id:digit}",
            "callable" => ["postNewEditDeleteController", "edit"]
        ],
    ],
];
