<form action="<?= $di->get('url')->create("admin/users/edit/".$user['id']) ?>" method="post">
    <p>
        <input
            class="comments-input"
            type="text"
            name="username"
            required
            placeholder="<användarnamn>"
            value="<?= $user['username'] ?>"
        >
    </p>
    <p>
        <input
            class="comments-input"
            type="text"
            name="email"
            required
            placeholder="<e-postadress>"
            value="<?= $user['email'] ?>"
        >
    </p>
   <p class="text-right">
        <input class="button" type="submit" value="Ändra">
    </p>
</form>

<hr>

<a href="<?= $this->di->get('url')->create('admin/users') ?>">Tillbaka</a>
