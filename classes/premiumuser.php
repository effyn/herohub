<?php

class PremiumUser extends User
{
    private $_heroes;
    private $_role;

    /**
     * PremiumUser constructor.
     *
     * @param array $_heroes
     */
    public function __construct($platform, $email, $passhash)
    {
        parent::__construct($platform, $email, $passhash);
    }

    /**
     * @return array
     */
    public function getHeroes()
    {
        return $this->_heroes;
    }

    /**
     * Sets the hero selections for a PremiumUser.
     *
     * $heroes must be exactly 3 elements long and contain valid heroes:
     * FIXME: I checked the api special characters cannot pull lucio or trobjorn works without,
     *       full roster can be pulled api documentation example list was incomplete.
     * array('bastion', 'dVa', 'genji', 'hanzo', 'junkrat', 'lúcio',
     * 'mccree', 'mei', 'mercy', 'orisa', 'pharah', 'reaper', 'reinhardt',
     * 'roadhog', 'soldier76', 'sombra', 'symmetra', 'torbjörn', 'tracer',
     * 'widowmaker', 'winston', 'zarya', 'zenyatta')
     *
     * @param array $heroes
     */
    public function setHeroes($heroes)
    {
        $this->_heroes = $heroes;
    }

    /**
     * Gets the role priority
     * @return int
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * Sets the role priority
     * @param int $role
     */
    public function setRole($role)
    {
        $this->_role = $role;
    }
}