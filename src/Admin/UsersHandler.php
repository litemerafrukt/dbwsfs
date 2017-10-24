<?php

namespace litemerafrukt\Admin;

use litemerafrukt\User\UserLevels;

/**
 * Class for administrating users
 */
class UsersHandler
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get all users
     *
     * @return Collection
     */
    public function all()
    {
        $sql = "SELECT * FROM users";
        return $this->db->query2collection($sql);
    }

    /**
     * Get user with id
     *
     * @param int $id
     *
     * @return array
     */
    public function fetchUser($id)
    {
        $sql = "SELECT * FROM users WHERE id=?";
        return $this->db->query2collection($sql, [$id])->first();
    }

    /**
     * Get user with username
     *
     * @param string $username
     *
     * @return array
     */
    public function fetchUserByName($username)
    {
        $sql = "SELECT * FROM users WHERE username=?";
        return $this->db->query2collection($sql, [$username])->first();
    }

    /**
     * Set user with id to admin
     *
     * @param int
     * @param string
     * @param string
     *
     * @return array [bool, string]
     */
    public function makeAdmin($id)
    {
        $sql = "UPDATE users SET userlevel=? WHERE id=?";
        $statement = $this->db->query($sql, [UserLevels::ADMIN, $id]);
        if ($statement->errorCode() !== '00000') {
            return [false, "Kunde inte gör anvädare med id=$id till administratör."];
        }
        return [true, "Användare nr: $id, har nu administratörsrättigheter."];
    }

    /**
     * Delete user with id
     *
     * @param int
     *
     * @return array [bool, string]
     */
    public function deleteUser($id)
    {
        $sql = "UPDATE users SET deleted=? WHERE id=?";
        $statement = $this->db->query($sql, [\date("Y-m-d H:i:s"), $id]);
        if ($statement->errorCode() !== '00000') {
            return [false, "Kunde inte ta bort anvädare med id=$id."];
        }
        return [true, "Användare nr: $id, satt som borttagen."];
    }

    /**
     * Activate user with id
     *
     * @param int
     *
     * @return array [bool, string]
     */
    public function activateUser($id)
    {
        $sql = "UPDATE users SET deleted=NULL WHERE id=?";
        $statement = $this->db->query($sql, [$id]);
        if ($statement->errorCode() !== '00000') {
            return [false, "Kunde inte aktivera anvädare med id=$id."];
        }
        return [true, "Användare nr: $id, aktiverad."];
    }
}
