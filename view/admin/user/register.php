<form action="<?= $di->get('url')->create("admin/users/register") ?>" method="post">
    <p>
        <input
            class="comments-input"
            type="text"
            name="username"
            required
            placeholder="<användarnamn>"
        >
    </p>
    <p>
        <input
            class="comments-input"
            type="text"
            name="email"
            required
            placeholder="<e-postadress>"
        >
    </p>
    <p>
        <input
            class="comments-input"
            type="password"
            name="password1"
            required
            placeholder="<nytt lösenord>"
        >
    </p>
    <p>
        <input
            class="comments-input"
            type="password"
            name="password2"
            required
            placeholder="<repetera nytt lösenord>"
        >
    </p>
    <p class="text-right">
        <input class="button" type="submit" value="Registrera">
    </p>
</form>

<hr>

<a href="<?= $this->di->get('url')->create('admin/users') ?>">Tillbaka</a>
