<?php

// should work for anyone with a config.php in their user directory
require_once "/home/{$_SERVER['USER']}/config.php";

class Database
{
    private $db;

    public function __construct__()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    }

    /**
     * Inserts a User into the database. For a PremiumUser, insertPremiumUser must also be called.
     *
     * @param $user User the user to insert into the herohub-user table
     */
    public function insertUser($user)
    {
        //TODO: impl
    }

    //TODO: determine whether this function is really necessary
    /**
     * Inserts a PremiumUser in the database. insertUser must be called before this.
     *
     * @param $user PremiumUser the premium user to insert into the herohub-premiumuser table
     */
    public function insertPremiumUser($user)
    {
        //TODO: impl
    }

    /**
     * Updates a User that exists in the database.
     *
     * @param $user User the user to update
     * @param $params array associative array of supported parameters
     * @see comments
     */
    public function updateUser($user, $params)
    {
        //TODO: impl
    }

    //TODO: determine whether this function is really necessary
    /**
     * Updates a PremiumUser that exists in the database.
     *
     * @param $user PremiumUser the user to update
     * @param $params array associative array of supported parameters
     * @see comments
     */
    public function updatePremiumUser($user, $params)
    {
        //TODO: impl
    }

    /**
     * Deletes a User from the database.
     *
     * @param $user User|PremiumUser the user to delete
     */
    public function deleteUser($user, $params)
    {
        //TODO: impl
    }
}