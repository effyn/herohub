<?php

class User
{
    // Defaults to -1 so that instantiated objects have no null fields.
    // A User's ID should be set ONLY if it has been inserted in the database.
    private $_id = -1;
    private $_fname;
    private $_lname;
    private $_btag;
    private $_email;
    private $_passhash;

    /**
     * @param string $fname
     * @param string $lname
     * @param string $btag
     * @param string $email
     * @param string $passhash
     */
    public function __construct__($fname, $lname, $btag, $email, $passhash)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_btag = $btag;
        $this->_email = $email;
        $this->_passhash = $passhash;
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
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * Sets the first name for the User.
     * This should only be called when the user requests a first name change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return string
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * Sets the last name for the User.
     * This should only be called when the user requests a last name change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return string
     */
    public function getBtag()
    {
        return $this->_btag;
    }

    /**
     * Sets the BattleTag for the User.
     * This should only be called when the user requests a BattleTag change,
     * and you should properly update the herohub-user row first.
     *
     * @param string $btag
     */
    public function setBtag($btag)
    {
        $this->_btag = $btag;
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
}