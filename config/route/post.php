<?php
/**
 * Routes for commenting system.
 */

return [
    "routes" => [
        [
            "info" => "Check post request for new or edit comment.",
            "requestMethod" => "post",
            "path" => "show/{postId:digit}",
            "callable" => ["commentHandleController", "newEditComment"]
        ],
        [
            "info" => "Comment vote up.",
            "requestMethod" => "get",
            "path" => "voteup/{commentId:digit}",
            "callable" => ["commentHandleController", "voteUp"]
        ],
        [
            "info" => "Comment vote down.",
            "requestMethod" => "get",
            "path" => "votedown/{commentId:digit}",
            "callable" => ["commentHandleController", "voteDown"]
        ],
        [
            "info" => "Toggle mark comment.",
            "requestMethod" => "get",
            "path" => "mark/{commentId:digit}",
            "callable" => ["commentHandleController", "toggleMark"]
        ],
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
