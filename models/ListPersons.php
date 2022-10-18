<?php

class ListPersons
{
    private $persons; // Persons

    function __construct($persons = array())
    {
        foreach ($persons as $curKey => $person) {
            array_push($persons, $person);
        }
    }

    public function getPersons()
    {
        return $this->persons;
    }

    public function findByName(string $name)
    {
        foreach ($this->persons as $curKey => $currentPerson) {
            if ($name === $currentPerson->getName()) return $currentPerson;
        }
        return null;
    }

    public function findByCodePostal(string $code)
    {
        foreach ($this->persons as $curKey => $currentPerson) {
            $currentPersonAddresses = $currentPerson->getAddress();

            foreach ($currentPersonAddresses as $curKey => $addr) {
                if ($addr->getCodePostal() === $code) return true;
            }
        }
        return false;
    }

    public function editPersonName(string $oldName, string $newName)
    {
        $person = $this->findByName($oldName);
        if ($person) {
            $person->setName($newName);
        }
    }

    public function editPersonneVille(string $nom, string $newVille)
    {
        $person = $this->findByName($nom);
        if ($person) {
            foreach ($person->getAddress() as $curKey => $addr) {
                $addr->setVille($newVille);
            }
        }
    }
}
