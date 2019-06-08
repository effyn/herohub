<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file defines the connection to the DB and the queries for the app

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
        //TODO: use instanceof to determine whether to insert a new row
        // in herohub-premiumuser as well
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
        //TODO: use instanceof to determine whether to update a row
        // in herohub-premiumuser as well
    }

    /**
     * Deletes a User from the database.
     *
     * @param $user User the user to delete
     */
    public function deleteUser($user, $params)
    {
        //TODO: impl
        //TODO: use instanceof to determine whether to delete a row
        // from herohub-premiumuser as well
    }
}