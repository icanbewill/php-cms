<?php


class Person
{
    private $rue; // string
    private $ville; //ville
    private $codePostal; //codePostal

    function __construct($rue = '', $ville = '', $codePostal = 00000)
    {
        $this->rue = $rue;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
    }

    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    public function getRue()
    {
        return $this->rue;
    }

    public function getSex()
    {
        return $this->ville;
    }

    public function getCodePostal()
    {
        return $this->codePostal;
    }
}
