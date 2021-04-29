<?php
          class User
          {
                    public $name;
                    public $city;
                    public $country;
                    public function __construct($name = null,$city = null,$country = null){
                              $this->name = $name;
                              $this->city = $city;
                              $this->country = $country;
                    }
                    public function getAllUser(){
                              return array(
                                        "Ram" => new User("Ram","Delhi","India"),
                                        "John Doe" => new User("John Doe","Boston","USA")
                              );
                    }
                    public function getUser($name){
                              $users = $this->getAllUser();
                              return $users[$name];
                    }
          } 
?>