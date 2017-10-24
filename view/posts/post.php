<h2>
    <?= htmlspecialchars($post->subject) ?>
</h2>

<p><?= $post->getText($formatter)?></p>

<h6 class="post-tags">
    <?php if (!empty($post->tags)) : ?>
        <ul class="post-tags-list">
        <?php foreach ($post->tags as $tag) : ?>
                <li>
                    <a href="<?= $this->di->get('url')->create('posts/tag')."/".urlencode($tag->tag) ?>">
                        <?= $tag->tag ?>
                    </a>
                </li>
        <?php endforeach ?>
        </ul>
    <?php else : ?>
        no tags
    <?php endif ?>
</h6>

<div class="post-footer">

    <?php if ($post->authorId == $user->id() || $user->isAdmin) : ?>
        <div class="post-form">
            <a class="comment-button rm1" href="<?= $di->get('url')->create('post/edit/' . $post->id) ?>">
                ändra
            </a>
            <a href="<?= $di->get('url')->create('post/delete/' . $post->id) ?>"
                class="delete comment-button rm1"
                data-confirm="Är du säker på att du vill ta bort posten: "<?= htmlspecialchars($post->subject) ?>"?"
            >
                ta bort
            </a>
        </div>
    <?php endif ?>

    <div>
        <span><?= $post->points ?> poäng</span>

        <?php if ($user->isUser) : ?>
            <form class="post-form" method="post" action="<?= $this->di->get('url')->create('post/vote')."/".$post->id ?>">
                <input class="comment-button rm1" type="submit" name="vote-up-submitted" value="+1">
                <input class="comment-button rm1" type="submit" name="vote-down-submitted" value="-1">
            </form>
        <?php endif ?>
    </div>

    <div class="post-author">
        <img src="<?= $post->gravatar->url() ?>" alt="<?= $post->authorEmail ?>">
        <div>
            <span>
                <a href="<?= $this->di->get('url')->create('user/profile/'.$post->author) ?>">
                    <?= $post->author ?: $post->authorEmail ?>
                </a>
            </span>
            <br>
            <span class="smaller-text">@ <?= $post->created ?>
                <br>
                <?= !is_null($post->updated) ? "& $post->updated" : "" ?>
            </span>
        </div>
    </div>

</div>

<hr>

<a name="comments"></a>

<p>Sortera på:
    <a class="<?= $sortBy == 'id' ? 'active' : '' ?>" href="?sort=id">nyast</a>,
    <a class="<?= $sortBy == 'points' ? 'active' : '' ?>" href="?sort=points">poäng</a>
</p>

<p><?= $commentsHTML ?></p>
