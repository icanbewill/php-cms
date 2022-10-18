<?php

class Person
{
    private $name; // string
    private $sex; //ville
    private $addresses; //codePostal

    function __construct($name = '', $sex = '', $addresses = [])
    {
        $this->name = $name;
        $this->sex = $sex;
        $this->addresses = $addresses;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getAddress()
    {
        return $this->addresses;
    }
}
