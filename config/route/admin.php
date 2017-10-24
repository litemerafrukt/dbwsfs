<?php
// Routes for user account managing

return [
    "routes" => [
        [
            "info" => "Guard the admin pages",
            "requestMethod" => null,
            "path" => "**",
            "callable" => ["adminController", "guard"]
        ],
        // [
        //     "info" => "Admin page",
        //     "requestMethod" => "get",
        //     "path" => "",
        //     "callable" => ["adminController", "index"]
        // ],
        [
            "info" => "Admin users page",
            "requestMethod" => "get",
            "path" => "users",
            "callable" => ["adminUsersController", "users"]
        ],
        [
            "info" => "Admin new user",
            "requestMethod" => "get",
            "path" => "users/register",
            "callable" => ["adminUsersController", "register"]
        ],
        [
            "info" => "Handle admin new user",
            "requestMethod" => "post",
            "path" => "users/register",
            "callable" => ["adminUsersController", "handleRegister"]
        ],
        [
            "info" => "Admin edit user",
            "requestMethod" => "get",
            "path" => "users/edit/{id:digit}",
            "callable" => ["adminUsersController", "edit"]
        ],
        [
            "info" => "Handle admin edit user",
            "requestMethod" => "post",
            "path" => "users/edit/{id:digit}",
            "callable" => ["adminUsersController", "handleEdit"]
        ],
        [
            "info" => "Admin delete user",
            "requestMethod" => "get",
            "path" => "users/delete/{id:digit}",
            "callable" => ["adminUsersController", "delete"]
        ],
        [
            "info" => "Admin make user admin",
            "requestMethod" => "get",
            "path" => "users/promote/{id:digit}",
            "callable" => ["adminUsersController", "makeAdmin"]
        ],
        [
            "info" => "Activate user",
            "requestMethod" => "get",
            "path" => "users/activate/{id:digit}",
            "callable" => ["adminUsersController", "activate"]
        ],
    ]
];
