<img class="mobile-noshow" src="<?= $this->di->get('url')->asset('img/lambda.jpg') ?>" alt="lambdapower!">
<?php if ($this->di->user->isLevel(litemerafrukt\User\UserLevels::USER)) : ?>
    <div class="aside-buttonlike-wrap">
        <a href="<?= $this->di->get('url')->create('post/new/p') ?>">Nytt inlägg</a>
        <a href="<?= $this->di->get('url')->create('post/new/q') ?>">Ny fråga</a>
    </div>
<?php else : ?>
    <div class="aside-buttonlike-wrap">
        <a href="<?= $this->di->get('url')->create('user/login') ?>">Logga in</a>
    </div>
<?php endif ?>

<div class="aside-users">
    <h3>topplistan</h3>
    <table>
        <tr>
        <th>anv</th>
        <th>cred</th>
        <th>inl</th>
        </tr>
        <?php foreach ($topUsers as $topUser) : ?>
            <tr>
            <td>
                <a href="<?= $this->di->get('url')->create('user/profile/'.$topUser['username']) ?>">
                    <?= $topUser['username'] ?>
                </a>
            </td>
            <td><?= $topUser['cred'] ?></td>
            <td><?= $topUser['nrOfPosts'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>

<div class="aside-about">
    <a href="<?= $this->di->url->create('about') ?>">
        <h3>Om</h3>
        <p>Forum om funktionell programmering.</p>
    </a>
</div>
