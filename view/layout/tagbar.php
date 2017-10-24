<nav class="tagbar">
    <ul class="tagbar-list">
        <li>
            <a class="toptag-page" href="<?= $this->di->get('url')->create('tags') ?>">toptags:</a>
        </li>

        <?php foreach ($toptags as $tag) : ?>
            <li>
                <a href="<?= $this->di->get('url')->create('posts/tag')."/".urlencode($tag->tag) ?>">
                    <?= $tag->tag ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</nav>
