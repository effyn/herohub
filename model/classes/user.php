<?php

class User
{
    // default id so i dont pull my hair out over a null pointer
    private $_id = -1;
    private $_username;
    private $_passhash;
    private $_email;
    private $_timezone;

    /**
     * @param string $username
     * @param string $passhash
     * @param string $email
     * @param int $timezone
     */
    public function __construct__($username, $passhash, $email, $timezone)
    {
        $this->_username = $username;
        $this->_passhash = $passhash;
        $this->_email = $email;
        $this->_timezone = $timezone;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets the ID acquired from the database for this User.
     * This should only be called after a herohub-user row is inserted.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Sets the username for the User.
     * This should only be called when the user requests a username change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
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
     * @return string
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
     * @return int
     */
    public function getTimezone()
    {
        return $this->_timezone;
    }

    /**
     * Sets the timezone for a User.
     * This should only be called when the user updates their information.
     * and you should properly update the herohub-user row first.
     *
     * @param int $timezone
     */
    public function setTimezone($timezone)
    {
        $this->_timezone = $timezone;
    }




}