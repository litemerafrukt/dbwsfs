<?php
// Routes for user account managing

return [
    "routes" => [
        [
            "info" => "User registration",
            "requestMethod" => "get|post",
            "path" => "register",
            "callable" => ["userRegisterController", "register"]
        ],
        [
            "info" => "user login",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["userController", "login"]
        ],
        [
            "info" => "user logout",
            "requestMethod" => "get",
            "path" => "logout",
            "callable" => ["userController", "logout"]
        ],
        [
            "info" => "User profile",
            "requestMethod" => "get",
            "path" => "profile",
            "callable" => ["userAccountController", "profile"]
        ],        [
            "info" => "User profile",
            "requestMethod" => "get",
            "path" => "profile/{username}",
            "callable" => ["userAccountController", "profile"]
        ],
        [
            "info" => "Lock the account path",
            "requestMethod" => null,
            "path" => "account/**",
            "callable" => ["userController", "guard"],
        ],
        [
            "info" => "User edit profile",
            "requestMethod" => "get|post",
            "path" => "account/profile/edit",
            "callable" => ["userAccountController", "editProfile"]
        ],
        [
            "info" => "User change password",
            "requestMethod" => "get|post",
            "path" => "account/password",
            "callable" => ["userAccountController", "changePassword"]
        ],
    ]
];
