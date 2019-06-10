<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file defines the standard User class that has access to base features

class User
{
    // Defaults to 0 so that instantiated objects have no null fields.
    // A User's ID should be set ONLY if it has been inserted in the database.
    private $_id = 0;
    private $_platform;
    private $_email;
    private $_passhash;
    private $_tag;
    private $_region;
    private $_micPref;
    private $_leaderPref;

    /**
     * User constructor.
     *
     * @param string $platform string
     * @param string $email string
     * @param string $passhash string
     */
    public function __construct($platform, $email, $passhash)
    {
        $this->_platform = $platform;
        $this->_email = $email;
        $this->_passhash = $passhash;
    }

    /**
     * Gets the User account id.
     *
     * @return int User id
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets the ID acquired from the database for this User.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Gets the User tag which is either a PSN ID, Gamertag, or a BattleTag.
     *
     * @return string PSN ID / Gamertag / BattleTag
     */
    public function getTag()
    {
        return $this->_tag;
    }

    /**
     * Sets the BattleTag / Gamertag / PSN ID for the User.
     * This should only be called when the user requests a tag change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->_tag = $tag;
    }

    /**
     * Gets a User email.
     *
     * @return string User email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the email address for a User.
     * This should only be called when the user requests an email address change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * Gets User password.
     *
     * @return string User password
     */
    public function getPasshash()
    {
        return $this->_passhash;
    }

    /**
     * Sets the password hash for a User.
     * This should only be called when the user requests a password change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $passhash
     */
    public function setPasshash($passhash)
    {
        $this->_passhash = $passhash;
    }

    /**
     * Gets the User gaming platform.
     *
     * @return string Gaming platform.
     */
    public function getPlatform()
    {
        return $this->_platform;
    }

    /**
     * Sets the platform for a User. Must be in array('pc', 'xbl', 'psn').
     *
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->_platform = $platform;
    }

    /**
     * Gets User player region. This field is for PC players
     * using a BattleTag.
     *
     * @return string User player region
     */
    public function getRegion()
    {
        return $this->_region;
    }

    /**
     * Sets the region for a User. Must be in array('us', 'eu', 'asia').
     *
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->_region = $region;
    }

    /**
     * Gets the User mic preference.
     *
     * @return int Mic preference
     */
    public function getMicPref()
    {
        return $this->_micPref;
    }

    /**
     * Sets the microphone preference for a User.
     *
     * @param int $micPref
     */
    public function setMicPref($micPref)
    {
        $this->_micPref = $micPref;
    }

    /**
     * Gets the User leadership preference.
     *
     * @return int User leadership preference.
     */
    public function getLeaderPref()
    {
        return $this->_leaderPref;
    }

    /**
     * Sets the Leader preference for a User.
     *
     * @param int $leaderPref
     */
    public function setLeaderPref($leaderPref)
    {
        $this->_leaderPref = $leaderPref;
    }
}