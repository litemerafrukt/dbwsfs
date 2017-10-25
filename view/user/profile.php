<h2>Profil för <?= $user->name ?></h2>

<div class="user-profile-top-wrap">
    <div class="user-profile-info">
        <img src="<?= $user->gravatar->url() ?>" alt="ingen gravatar">
        <p><strong>Användarnamn:</strong> <?= $user->name ?></p>
        <p><strong>E-postadress:</strong> <a href="mailto: <?= htmlspecialchars($user->email) ?>"><?= htmlspecialchars($user->email)?></a></p>
        <p><strong>Cred:</strong> <?= $user->cred ?> </p>
    </div>
    <div class="user-profile-controls">
        <?php if (!$publicProfile) : ?>
            <?php if ($user->isAdmin) : ?>
                <p>
                    <a href="<?= $this->di->get('url')->create('admin/users') ?>">
                        <strong>Administrera användare</strong>
                    </a>
                </p>
            <?php endif ?>

            <p>
                <a
                    class="text-right"
                    href="<?= $this->di->get('url')->create('user/account/profile/edit/') ?>"
                >Ändra profil</a>
            </p>
            <p>
                <a
                    class="text-right"
                    href="<?= $this->di->get('url')->create('user/logout') ?>"
                >Logga ut</a>
            </p>
        <?php endif ?>
    </div>
</div>

<hr>

<div class="user-profile-posts-comments">
    <div class="user-profile-posts">
        <h3>Inlägg och frågor</h3>
        <?php foreach ($posts as $post) : ?>
            <p>
                <a href="<?= $this->di->get('url')->create('post/show/'.$post->id) ?>">
                    <span class="post-list-post-heading"><?= htmlspecialchars($post->subject) ?></span>
                </a>
                <br>
                <span class="smaller-text">
                    @ <?= $post->created ?><?= !is_null($post->updated) ? "& $post->updated" : "" ?>
                </span>
                <br>
                <span>
                    <?= $post->points ?> poäng
                </span>
            </p>
        <?php endforeach ?>
    </div>

    <div class="user-profile-comments">
        <h3>Kommentarer</h3>
        <?php foreach ($comments as $comment) : ?>
            <p>
                <a href="<?= $this->di->get('url')->create('post/show/'.$comment->postId) ?>">
                    <span class=""><?= $this->di->get('formatter')($comment->text) ?></span>
                </a>
                <br>
                <span class="smaller-text">
                    @ <?= $comment->created ?><?= !is_null($comment->updated) ? "& $comment->updated" : "" ?>
                </span>
                <br>
                <span>
                    <?= $comment->points ?> poäng
                </span>
            </p>
        <?php endforeach ?>
    </div>
</div>
