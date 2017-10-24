<?php

namespace litemerafrukt\User;

/**
 * User handling database interaction
 */
class UserHandler
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Try to login user
     *
     * @param string
     * @param string
     *
     * @return array [bool, string|User]
     */
    public function login($username, $password)
    {
        // Lookup in database
        $sql = 'SELECT * from users WHERE username=? AND deleted IS NULL';
        $userFromDb = $this->db->query2collection($sql, [$username])
            ->first();

        if (!$userFromDb) {
            return [false, "Användare: $username, hittas inte i databasen."];
        }

        if (! \password_verify($password, $userFromDb['password'])) {
            return [false, "Felaktigt lösenord."];
        }

        $user = new User(
            $userFromDb['id'],
            $userFromDb['username'],
            $userFromDb['email'],
            $userFromDb['userlevel'],
            $userFromDb['cred']
        );

        return [true, $user];
    }

    /**
     * Register new user
     *
     * @param string $name
     * @param string $password
     * @param string $email
     * @param int $level
     *
     * @return array [bool, string|User]
     */
    public function register($name, $password, $email, $level = UserLevels::USER)
    {
        $passHash = \password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, userlevel) VALUES (?,?,?,?)";
        $statement = $this->db->query($sql, [$name, $passHash, $email, $level]);

        if ($statement->errorCode() !== '00000') {
            return [false, "Kunde inte registrera $name. Användarnamn eller e-postadress är förmodligen inte unikt."];
        }

        $id = $this->db->getPDO()->lastInsertId();

        $user = new User($id, $name, $email, $level, 0);

        return [true, $user];
    }

    /**
     * Update user profile
     *
     * @param int
     * @param string
     * @param string
     *
     * @return array [bool, string]
     */
    public function update($id, $name, $email)
    {
        $sql = "UPDATE users SET username=?, email=? WHERE id=?";
        $statement = $this->db->query($sql, [$name, $email, $id]);
        if ($statement->errorCode() !== '00000') {
            return [false, "Kunde inte uppdatera användare $name. Användarnamn eller e-postadress är förmodligen inte unikt."];
        }
        return [true, "Profilen för $name är uppdaterad."];
    }

    /**
     * Add cred
     *
     * @param int
     * @param int
     *
     * @return array
     */
    public function setCred($id, $cred)
    {
        $sql = "UPDATE users SET cred=? WHERE id=?";
        $statement = $this->db->query($sql, [$cred, $id]);
        if ($statement->errorCode() !== '00000') {
            return [false, "Kunde inte uppdatera cred"];
        }
        return [true, "Cred uppdaterad."];
    }

    /**
     * Change password
     *
     * @param int $id
     * @param string $password
     *
     * @return array [bool, string]
     */
    public function changePassword($id, $password)
    {
        $passHash = \password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE id=?";
        $statement = $this->db->query($sql, [$passHash, $id]);
        if ($statement->errorCode() !== '00000') {
            return [false, "Fel vid ändring av lösenord."];
        }
        return [true, "Lösenordet ändrat."];
    }
}
