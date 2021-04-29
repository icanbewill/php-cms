<?php
include 'mother/Model.php';
class FacturesMod extends Model{
    public $string;
    public $sql;
    public function __construct(){
        //$this->string = "MVC + PHP = Awesome!";
    }

    public function getTypes(){
        $sql = 'SELECT * FROM types_modeles';
        return $this->executerRequete($sql); 
    }

    public function getNiveaux(){
        $sql = 'SELECT * FROM niveaux_modeles';
        return $this->executerRequete($sql); 
    }
}
?>