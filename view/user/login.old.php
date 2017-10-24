<form action="<?= $di->get('url')->create("user/login") ?>" method="post">
    <p>
        <input class="comments-input" type="text" name="username" required placeholder="<användarnamn>">
    </p>
    <p>
        <input class="comments-input" type="password" name="password" required placeholder="<lösenord>">
    </p>
    <p class="text-right"><input class="button" type="submit" value="Logga in"></p>
</form>

<hr>

<a href="<?= $this->di->get('url')->create('user/register') ?>">Skapa ny användare</a>
