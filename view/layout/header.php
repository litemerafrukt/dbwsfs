<?php if ($di->get('view')->hasContent("tagbar")) : ?>
    <div class="tagbar-wrap">
        <?php $di->get('view')->render("tagbar") ?>
    </div>
<?php endif; ?>

<div class="logo-area">
    <div class="logo">
        <a href="<?= $this->di->get('url')->create('') ?>">
            <h1>dbwebb-students funktionella studiegrupp</h1>
        </a>
    </div>

    <?php if ($di->get('view')->hasContent("loginButton")) : ?>
        <div class="login-button-wrap">
            <?php $di->get('view')->render("loginButton") ?>
        </div>
    <?php endif; ?>
</div>

<div class="header-page-menu">
    <?php if ($di->get('view')->hasContent("pageMenu")) : ?>
        <div class="page-menu-wrap">
            <?php $di->get('view')->render("pageMenu") ?>
        </div>
    <?php endif; ?>
</div>

<?php if ($di->get('view')->hasContent("flash")) : ?>
    <div class="flash-wrap">
        <?php $di->get('view')->render("flash") ?>
    </div>
<?php endif ?>
