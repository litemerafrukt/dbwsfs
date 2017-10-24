<nav class="pagemenu">
    <?php foreach ($routes as $route) : ?>
        <a
                href="<?= $route['route'] ?>"
                class="nav-item <?= $route['route'] == $di->get('request')->getCurrentUrl() ? 'active' : '' ?>"
        ><?= $route['label'] ?></a>
    <?php endforeach; ?>
</nav>
