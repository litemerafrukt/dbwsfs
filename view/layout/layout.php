<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="<?= $di->get('url')->asset('css/lib/normalize.css') ?>">
    <link rel="stylesheet" href="<?= $di->get('url')->asset('css/build/app.css') ?>">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
    <link rel="shortcut icon" href="<?= $di->get('url')->asset('img/favicon.ico') ?>">
</head>
<body>

<div class="wrap-all">
    <header class="header">
        <?php if ($di->get('view')->hasContent("header")) : ?>
            <div class="header-wrap">
                <?php $di->get('view')->render("header") ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="main-aside-wrap">
        <main class="main">
            <?php if ($di->get('view')->hasContent("main")) : ?>
                <div class="main-wrap">
                    <?php $di->get('view')->render("main") ?>
                </div>
            <?php endif; ?>
        </main>

        <aside class="aside">
            <?php if ($di->get('view')->hasContent("aside")) : ?>
                <?php $di->get('view')->render("aside") ?>
            <?php endif; ?>
        </aside>
    </div>

    <footer class="footer text-center">
        <p>Made by: <a href="mailto:litemerafrukt@gmail.com">litemerafrukt</a></p>
    </footer>
</div>

<script src="<?= $di->get('url')->asset('js/build/app.js') ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
</body>
</html>
