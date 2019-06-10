<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file defines the connection to the DB and the queries for the app

// should work for anyone with a config.php in their user directory
require_once "/home/{$_SERVER['USER']}/config.php";

class Database
{
    private static $insertUserSQL = 'INSERT INTO `herohub_user`' .
    '(platform,  email,  passhash,  tag,  region,  micpref,  leaderpref' .
    ')VALUES(' .
    ':platform, :email, :passhash, :tag, :region, :micpref, :leaderpref);';

    private static $insertPremiumUserSQL = 'INSERT INTO `herohub_premiumuser`' .
    '(id,  role,  hero1,  hero2,  hero3' .
    ')VALUES(' .
    ':id, :role, :hero1, :hero2, :hero3);';

    private static $updateAccountSQL = 'UPDATE `herohub_user` ' .
    'SET platform = :platform, email = :email, passhash = :passhash ' .
    'WHERE id = :id;';

    private static $updatePreferencesSQL = 'UPDATE `herohub_user` ' .
    'SET tag = :tag, region = :region, micpref = :micpref, leaderpref = :leaderpref ' .
    'WHERE id = :id;';

    private static $loginSelectSQL = 'SELECT * FROM `herohub_user` WHERE ' .
    'email = :email AND passhash = :passhash;';

    private static $heroSelectSQL = 'SELECT * FROM `herohub_premiumuser` WHERE ' .
    'hero1 = :hero OR hero2 = :hero OR hero3 = :hero;';

    private static $selectUserSQL = 'SELECT * FROM `herohub_user` WHERE ' .
    'id = :id;';

    private static $selectPremiumUserSQL = 'SELECT * FROM `herohub_premiumuser` WHERE ' .
    'id = :id;';

    private static $deleteAccountSQL = 'DELETE FROM `herohub_user` WHERE ' .
    'id = :id;';

    private static $deletePremiumAccountSQL = 'DELETE FROM `herohub_premiumuser` WHERE ' .
    'id = :id;';

    private $_db;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * This function connects the database to the config file.
     */
    private function connect()
    {
        try {
            $this->_db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        }catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Inserts a User into the database.
     *
     * @param $user User the user to insert into the herohub_user and herohub_premiumuser table
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

            if ($user instanceof PremiumUser) {
                $stmt = $db->prepare(self::$insertPremiumUserSQL);

                $role = $user->getRole();

                $heroes = $user->getHeroes();

                $hero1 = $heroes[0];
                $hero2 = $heroes[1];
                $hero3 = $heroes[2];

                $heroes = array();

                if (isset($heroes[0])) {
                    $hero1 = $heroes[0];
                }

                if (isset($heroes[1])) {
                    $hero2 = $heroes[1];
                }

                if (isset($heroes[2])) {
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

        } catch (PDOException $ex) {
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

        } catch (PDOException $ex) {
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

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Selects and returns a User that exists in the database.
     *
     * @param $user User the user to select and return
     * @return array the results of the query, might have PremiumUser data as well
     */
    public function selectUser($user)
    {

        $result = 'Unable to retrieve user account';
        try {

            //prepare the statement
            $db = $this->_db;
            $stmt = $db->prepare(self::$selectUserSQL);

            $id = $user->getId();

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            //execute
            $stmt->execute();

            //get the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user instanceof PremiumUser) {
                //define the query: is private static field

                //prepare the statement
                $stmt = $db->prepare(self::$selectUserPremiumSQL);

                //bind the params
                $stmt->bindParam(':id', $user->getId(), PDO::PARAM_INT);

                //execute
                $stmt->execute();

                //return the result
                $result .= $stmt->fetch(PDO::FETCH_ASSOC);
            }

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }

        return $result;
    }

    /**
     * Selects and returns a User that exists in the database.
     *
     * @return User the resulting User object, could be null
     */
    public function loginUser($email, $passhash)
    {
        //prepare the statement
        $db = $this->_db;
        $stmt = $db->prepare(self::$loginSelectSQL);

        //bind the params and execute
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':passhash', $passhash, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($data)) {
            // user not found with the email+password provided
            return null;
        }

        $stmt = $db->prepare(self::$selectPremiumUserSQL);

        $id = $data['id'];

        // bind and execute
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $premiumData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($premiumData)) {
            // initialize a generic User object
            $user = new User($data['platform'], $data['email'], $data['passhash']);
        } else {
            // otherwise, premium and call premium-specific setters
            $user = new PremiumUser($data['platform'], $data['email'], $data['passhash']);

            $user->setRole($premiumData['role']);

            $heroes = array();

            if (isset($premiumData['hero1'])) {
                $heroes[] = $premiumData['hero1'];
            }

            if (isset($premiumData['hero2'])) {
                $heroes[] = $premiumData['hero2'];
            }

            if (isset($premiumData['hero3'])) {
                $heroes[] = $premiumData['hero3'];
            }

            $user->setHeroes($heroes);
        }

        $user->setId($id);
        $user->setTag($data['tag']);
        $user->setRegion($data['region']);
        $user->setMicPref($data['micpref']);
        $user->setLeaderPref($data['leaderpref']);

        return $user;
    }

    /**
     * Selects a PremiumUser from the database with the specified hero choice.
     *
     * @param $hero hero choice to find matches for
     * @return array Result matching hero
     */
    public function selectUsersWithHero($hero)
    {
        $db = $this->_db;
        $stmt = $db->prepare(self::$heroSelectSQL);

        //bind the params and execute
        $stmt->bindParam(':hero', $hero, PDO::PARAM_STR);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = array();

        foreach ($rows as $premium) {
            $stmt = $db->prepare(self::$selectUserSQL);
            $id = $premium['id'];

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $userdata = $stmt->fetch(PDO::FETCH_ASSOC);

            $user = new PremiumUser($userdata['platform'], $userdata['email'], $userdata['passhash']);
            $user->setId($id);
            $user->setTag($userdata['tag']);
            $user->setRegion($userdata['region']);
            $user->setMicPref($userdata['micpref']);
            $user->setLeaderPref($userdata['leaderpref']);
            $user->setRole($premium['role']);

            $heroes = array();

            if (isset($premium['hero1'])) {
                $heroes[] = $premium['hero1'];
            }

            if (isset($premium['hero2'])) {
                $heroes[] = $premium['hero2'];
            }

            if (isset($premium['hero3'])) {
                $heroes[] = $premium['hero3'];
            }

            $user->setHeroes($heroes);

            $users[] = $user;
        }

        return $users;
    }

    /**
     * Deletes a User from the database.
     *
     * @param $user User the user to delete, deleting any PremiumUser data as well
     * @return int result of row delete
     */
    public function deleteUser($user)
    {
        //get the id to delete
        $id = $user->getId();

        //define the query - defined above

        //prepare the statement
        $db = $this->_db;
        $stmt = $db->prepare(self::$deleteAccountSQL);

        // bind params
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        //execute
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //also delete the from PremiumUser
        if ($user instanceof PremiumUser) {

            //define the query - needs to be defined above $deletePremiumAccountSQL

            //prepare the statement
            $stmt = $db->prepare(self::$deletePremiumAccountSQL);

            // bind params
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            //execute
            $stmt->execute();

            //return result if there is one
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $result;
    }
}