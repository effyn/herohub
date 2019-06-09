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

            if ($user instanceof PremiumUser)
            {
                $stmt = $db->prepare(self::$insertPremiumUserSQL);

                $id = $this->_db->lastInsertId();
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
        }

        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
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


        //FIXME: The statement should be generated based on the params that are given
        $db = $this->_db;
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