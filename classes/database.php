<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file defines the connection to the DB and the queries for the app

// should work for anyone with a config.php in their user directory
require_once "/home/{$_SERVER['USER']}/config.php";

class Database
{
    private static $insertUserSQL = 'INSERT INTO `herohub-user`' .
    '(platform,  email,  passhash,  tag,  region,  micpref,  leaderpref' .
    ')VALUES(' .
    ':platform, :email, :passhash, :tag, :region, :micpref, :leaderpref);';

    private static $insertPremiumUserSQL = 'INSERT INTO `herohub-premiumuser`' .
    '(id,  role,  hero1,  hero2,  hero3' .
    ')VALUES(' .
    ':id, :role, :hero1, :hero2, :hero3);';

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
        global $f3;
        $db = $f3->get('db');

        $stmt = $db->prepare(self::$insertUserSQL);

        //TODO: Bind params and execute

        //FIXME: old code from PDO to help me remember how to do this
//        $sid = $_POST['sid'];
//        $last = $_POST['last'];
//        $first = $_POST['first'];
//        $birthdate = date('Y-m-d', strtotime($_POST['birthdate']));
//        $gpa = $_POST['gpa'];
//        $advisor = $_POST['advisor'];
//
//        $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
//        $stmt->bindParam(':last', $last, PDO::PARAM_STR);
//        $stmt->bindParam(':first', $first, PDO::PARAM_STR);
//        $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
//        $stmt->bindParam(':gpa', $gpa, PDO::PARAM_STR);
//        $stmt->bindParam(':advisor', $advisor, PDO::PARAM_STR);
//        $stmt->execute();

        // TODO: remove this line after making sure this works
        var_dump($user);
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
        //TODO: describe params in a comment here,
        // keys should match the names of fields and assume values are valid

        global $f3;
        $db = $f3->get('db');

        //FIXME: The statement should be generated based on the params that are given
        $updateUserSQL = '';

        $stmt = $db->prepare($updateUserSQL);

        //TODO: impl,
        // use instanceof to determine whether to update a row
        // in herohub-premiumuser as well
    }

    /**
     * Selects and returns a User that exists in the database.
     *
     * @param $user User the user to select and return
     *
     * @return array the results of the query, might have PremiumUser data as well
     */
    public function selectUser($user)
    {
        //TODO: impl,
        // use instanceof to determine whether to select a row
        // in herohub-premiumuser as well and add its fields to the returned array

        //TODO: actually return the result of the query
        return array();
    }

    /**
     * Deletes a User from the database.
     *
     * @param $user User the user to delete, deleting any PremiumUser data as well
     */
    public function deleteUser($user)
    {
        //TODO: impl,
        // use instanceof to determine whether to delete a row
        // from herohub-premiumuser as well
    }
}