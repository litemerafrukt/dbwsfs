<h2>Taggar</h2>

<ul class="tags-list">
<?php foreach ($tags as $tag) : ?>
    <li>
        <a href="<?= $this->di->get('url')->create('posts/tag') . "/" . urlencode($tag->tag) ?>">
            <span>
                <?= $tag->tag ?>
            </span>
        </a>
        <span>
            <?= $tag->tagCount ?> inlägg
        </span>
    </li>
<?php endforeach ?>
</ul>
