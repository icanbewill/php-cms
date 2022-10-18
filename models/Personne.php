<?php

class Person
{
    private $id; // string
    private $name; // string
    private $sex; //ville
    private $addresses; //codePostal

    function __construct($id, $name = '', $sex = '', $addresses = [])
    {
        $this->id = $id;
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

    public function getId()
    {
        return $this->id;
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
