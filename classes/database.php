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

    private static $updateAccountSQL = 'UPDATE `herohub-user` ' .
    'SET platform = :platform, email = :email, passhash = :passhash ' .
    'WHERE id = :id;';

    private static $updatePreferencesSQL = 'UPDATE `herohub-user` ' .
    'SET tag = :tag, region = :region, micpref = :micpref, leaderpref = :leaderpref ' .
    'WHERE id = :id;';

    private $_db;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->_db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        }

        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Inserts a User into the database. For a PremiumUser, insertPremiumUser must also be called.
     *
     * @param $user User the user to insert into the herohub-user table
     */
    public function insertUser($user)
    {
        try {
            $db = $this->_db;
            $stmt = $db->prepare(self::$insertUserSQL);

            $platform = $user->getPlatform();
            $email = $user->getEmail();
            $passhash = $user->getPasshash();
            $tag = $user->getTag();
            $region = $user->getRegion();
            $micPref = $user->getMicPref();
            $leaderPref = $user->getLeaderPref();

            $stmt->bindParam(':platform', $platform, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':passhash', $passhash, PDO::PARAM_STR);
            $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
            $stmt->bindParam(':region', $region, PDO::PARAM_STR);
            $stmt->bindParam(':micpref', $micPref, PDO::PARAM_INT);
            $stmt->bindParam(':leaderpref', $leaderPref, PDO::PARAM_INT);

            $stmt->execute();

            $id = $this->_db->lastInsertId();

            if ($user instanceof PremiumUser)
            {
                $stmt = $db->prepare(self::$insertPremiumUserSQL);

                $role = $user->getRole();

                $heroes = $user->getHeroes();

                $hero1 = $heroes[0];
                $hero2 = $heroes[1];
                $hero3 = $heroes[2];

                $heroes = array();

                if (isset($heroes[0]))
                {
                    $hero1 = $heroes[0];
                }

                if (isset($heroes[1]))
                {
                    $hero2 = $heroes[1];
                }

                if (isset($heroes[2]))
                {
                    $hero3 = $heroes[2];
                }

                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':role', $role, PDO::PARAM_INT);
                $stmt->bindParam(':hero1', $hero1, PDO::PARAM_STR);
                $stmt->bindParam(':hero2', $hero2, PDO::PARAM_STR);
                $stmt->bindParam(':hero3', $hero3, PDO::PARAM_STR);

                $stmt->execute();
            }

            //FIXME note: if id is not 0, the user is considered DONE.
            // use this logic to determine whether or not a row should be inserted or updated
            $user->setId($id);
        }

        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Updates a User's account info.
     *
     * @param $id int The ID of the user to update
     * @param $platform string The user's game platform
     * @param $email string The user's email address
     * @param $passhash string The new password hash for the user
     */
    public function updateAccount($id, $platform, $email, $passhash)
    {
        try {
            $db = $this->_db;
            $stmt = $db->prepare(self::$updateAccountSQL);

            $stmt->bindParam(':platform', $platform, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':passhash', $passhash, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
        }

        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Updates a User's preferences.
     *
     * @param $id int The ID of the user to update
     * @param $tag string The user's tag, validated based on platform
     * @param $region string The user's game region
     * @param $micPref int The user's microphone preference
     * @param $leaderPref int The user's leader preference
     */
    public function updatePreferences($id, $tag, $region, $micPref, $leaderPref)
    {
        try {
            $db = $this->_db;
            $stmt = $db->prepare(self::$updatePreferencesSQL);

            $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
            $stmt->bindParam(':region', $region, PDO::PARAM_STR);
            $stmt->bindParam(':micpref', $micPref, PDO::PARAM_INT);
            $stmt->bindParam(':leaderpref', $leaderPref, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $stmt->execute();
        }

        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
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