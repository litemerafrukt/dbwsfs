<?php

/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
"services" => [
    "request" => [
        "shared" => true,
        "callback" => function () {
            $request = new \Anax\Request\Request();
            $request->init();
            return $request;
        }
    ],
    "response" => [
        "shared" => true,
        "callback" => function () {
            $obj = new \litemerafrukt\Response\Response();
            $obj->setDI($this);
            return $obj;
        }

    ],
    "previousRoute" => [
        "shared" => true,
        "callback" => function () {
            return $this->get("request")->getServer('HTTP_REFERER', $this->get('url')->create(""));
        }
    ],
    "url" => [
        "shared" => true,
        "callback" => function () {
            $url = new \Anax\Url\Url();
            $request = $this->get("request");
            $url->setSiteUrl($request->getSiteUrl());
            $url->setBaseUrl($request->getBaseUrl());
            $url->setStaticSiteUrl($request->getSiteUrl());
            $url->setStaticBaseUrl($request->getBaseUrl());
            $url->setScriptName($request->getScriptName());
            $url->configure("url.php");
            $url->setDefaultsFromConfiguration();
            return $url;
        }
    ],
    "router" => [
        "shared" => true,
        "callback" => function () {
            $router = new \Anax\Route\Router();
            $router->setDI($this);
            $router->configure("route.php");
            return $router;
        }
    ],
    "view" => [
        "shared" => true,
        "callback" => function () {
            $view = new \Anax\View\ViewCollection();
            $view->setDI($this);
            $view->configure("view.php");
            return $view;
        }
    ],
    "viewRenderFile" => [
        "shared" => true,
        "callback" => function () {
            $viewRender = new \Anax\View\ViewRenderFile2();
                // $viewRender = new litemerafrukt\Render\Render();
            $viewRender->setDI($this);
            return $viewRender;
        }
    ],
    "session" => [
        "shared" => true,
        "active" => true,
        "callback" => function () {
            $session = new \Anax\Session\SessionConfigurable();
            $session->configure("session.php");
            $session->start();
            return $session;
        }
    ],
    "textfilter" => [
        "shared" => true,
        "callback" => "\Anax\TextFilter\TextFilter",
    ],
    "errorController" => [
        "shared" => true,
        "callback" => function () {
            $obj = new \Anax\Page\ErrorController();
            $obj->setDI($this);
            return $obj;
        }
    ],
    "debugController" => [
        "shared" => true,
        "callback" => function () {
            $obj = new \Anax\Page\DebugController();
            $obj->setDI($this);
            return $obj;
        }
    ],
    "flatFileContentController" => [
        "shared" => true,
        "callback" => function () {
            $obj = new \Anax\Page\FlatFileContentController();
            $obj->setDI($this);
            return $obj;
        }
    ],
    "pageRender" => [
        "shared" => true,
        "callback" => function () {
            $obj = new \litemerafrukt\Render\Render();
            $obj->setDI($this);
            return $obj;
        }
    ],
    "olddb" => [
        "shared" => true,
        "callback" => function () {
            $db = new litemerafrukt\Database\Database();
            $db->configure('olddatabase.php');
            $db->connect();
            return $db;
        }
    ],
    "db" => [
        "shared" => true,
        "callback" => function () {
            $obj = new \Anax\Database\DatabaseQueryBuilder();
            $obj->configure("database.php");
            return $obj;
        }
    ],
    "user" => [
        "shared" => true,
        "callback" => function () {
            return $this->get('session')->get(
                'user',
                new litemerafrukt\User\User(null, 'Gäst', '', litemerafrukt\User\UserLevels::GUEST, 0)
            );
        }
    ],
    "tagModel" => [
        "shared" => true,
        "callback" => function () {
            $tagModel = new litemerafrukt\Tags\TagModel();
            $tagModel->setDb($this->get('db'));
            return $tagModel;
        }
    ],
    "tagsPosts" => [
        "shared" => true,
        "callback" => function () {
            $tagsPosts = new litemerafrukt\Tags\TagsPosts();
            $tagsPosts->setDb($this->get('db'));
            return $tagsPosts;
        }
    ],
    "tagsController" => [
        "shared" => true,
        "callback" => function () {
            $tagsController = new litemerafrukt\Controllers\TagsController($this->get('tagModel'));
            $tagsController->setDi($this);
            return $tagsController;
        }
    ],
    "layoutController" => [
        "shared" => true,
        "callback" => function () {
            $loginButton = (new litemerafrukt\Layout\LoginButton())->setDi($this);
            $pageMenu = (new litemerafrukt\Layout\PageMenu())->setDi($this)->configure("pagemenu.php");
            $aside = (new litemerafrukt\Layout\Aside())->setDi($this);

            $layoutController = new litemerafrukt\Controllers\LayoutController($loginButton, $pageMenu, $aside);
            $layoutController->setDI($this);
            return $layoutController;
        }
    ],
    "flash" => [
        "shared" => true,
        "callback" => function () {
            $flash = new \litemerafrukt\Flash\Flash();
            $flash->setDi($this);
            $flash->init();
            return $flash;
        }
    ],
    "postModel" => [
        "shared" => true,
        "callback" => function () {
            $postModel = new litemerafrukt\Posts\PostModel();
            $postModel->setDb($this->get('db'));
            return $postModel;
        }
    ],
    "posts" => [
        "shared" => true,
        "callback" => function () {
            $postSupplier = new litemerafrukt\Posts\Posts(
                $this->get('postModel'),
                $this->get('tagModel'),
                $this->get('tagsPosts')
            );
            return $postSupplier;
        }
    ],
    "commentModel" => [
        "shared" => true,
        "callback" => function () {
            $commentModel = new litemerafrukt\Comments\CommentModel();
            $commentModel->setDb($this->get('db'));
            return $commentModel;
        }
    ],
    "comments" => [
        "shared" => true,
        "callback" => function () {
            $purifier = new HTMLPurifier();
            $formatter = function ($rawText) use ($purifier) {
                $dirty = $this->get('textfilter')->markdown($rawText);
                return $purifier->purify($dirty);
            };

            $comments = new litemerafrukt\Comments\Comments($this->get('commentModel'), $formatter);
            return $comments;
        }
    ],
    "postsController" => [
        "shared" => true,
        "callback" => function () {
            $postsController = new litemerafrukt\Controllers\PostsController(
                $this->get('posts'),
                $this->get('comments'),
                $this->get('tagsPosts')
            );
            $postsController->setDi($this);
            return $postsController;
        }
    ],
    "postController" => [
        "shared" => true,
        "callback" => function () {
            $purifier = new HTMLPurifier();
            $textFormatter = function ($rawText) use ($purifier) {
                $dirty = $this->get('textfilter')->markdown($rawText);
                return $purifier->purify($dirty);
            };

            $postController = new litemerafrukt\Controllers\PostController(
                $this->get('posts'),
                $this->get('comments'),
                $textFormatter
            );
            $postController->setDi($this);
            return $postController;
        }
    ],
    "postNewEditDeleteController" => [
        "shared" => true,
        "callback" => function () {
            $postsController = new litemerafrukt\Controllers\PostNewEditDeleteController($this->get('posts'), $this->get('comments'));
            $postsController->setDi($this);
            return $postsController;
        }
    ],
    "userCred" => [
        "shared" => true,
        "callback" => function () {
            $userCred = new litemerafrukt\UserCred\UserCred();
            $userCred->setDI($this);
            return $userCred;
        }
    ],
    "userHandler" => [
        "shared" => true,
        "callback" => function () {
            $userHandler = new litemerafrukt\User\UserHandler($this->get('olddb'));
            return $userHandler;
        }
    ],
    "usersHandler" => [
        "shared" => true,
        "callback" => function () {
            $usersHandler = new litemerafrukt\Admin\UsersHandler($this->get('olddb'));
            return $usersHandler;
        }
    ],
    "userController" => [
        "shared" => true,
        "callback" => function () {
            $userController = new litemerafrukt\Controllers\UserController($this->get('userHandler'));
            $userController->setDI($this);
            return $userController;
        }
    ],
    "userAccountController" => [
        "shared" => true,
        "callback" => function () {
            $userController = new litemerafrukt\Controllers\UserAccountController($this->get('userHandler'));
            $userController->setDI($this);
            return $userController;
        }
    ],
    "userRegisterController" => [
        "shared" => true,
        "callback" => function () {
            $userController = new litemerafrukt\Controllers\UserRegisterController($this->get('userHandler'));
            $userController->setDI($this);
            return $userController;
        }
    ],
    "adminController" => [
        "shared" => true,
        "callback" => function () {
            $userController = new litemerafrukt\Controllers\AdminController();
            $userController->setDI($this);
            return $userController;
        }
    ],
    "adminUsersController" => [
        "shared" => true,
        "callback" => function () {
            $usersHandler = new litemerafrukt\Admin\UsersHandler($this->get('olddb'));
            $userController = new litemerafrukt\Controllers\AdminUsersController(
                $this->get('userHandler'),
                $this->get('usersHandler')
            );
            $userController->setDI($this);
            return $userController;
        }
    ],
],
];
