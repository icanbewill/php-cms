<?php

class  UserManager extends ModelCore{

      
          public function register() {

                    $_inputs = [
                              "nom" => [
                                        "required" => true
                              ],
                              "user_email" => [
                                        "filter" => "email",
                                        "required" => true,
                                        "unique" => "utilisateurs"
                              ],
                              "password" => [
                                        "min_characters" => 6,
                                        "required" => true
                              ],
                              "password_repeat" => [
                                        "matches" => "password",
                                        "required" => true
                              ],
                    ];
  
                    // Validation des champs
                    if(!Input::check($_POST, $_inputs)) {
                               return false;
                    }

                    try {
                              $salt = Hash::generateSalt(32);
                              $userID = self::createUser([
                                        "user_email" => Input::post("user_email"),
                                        "user_name" => Input::post("nom"),
                                        "user_pass" => Hash::generate(Input::post("password"), $salt),
                                        "salt" => $salt
                              ]);
                    
                              Flash::success(Text::get("REGISTER_USER_CREATED"));
                              return $userID;
                    } catch (Exception $ex) {
                              Flash::danger($ex->getMessage());
                    }
                    return false;
          }

          public function registeruser() {

                    $_inputs = [
                              "user_nom" => [
                                        "required" => true
                              ],
                              "user_email" => [
                                        "filter" => "email",
                                        "required" => true,
                                        "unique" => "utilisateurs"
                              ],
                              "password" => [
                                        "min_characters" => 6,
                                        "required" => true
                              ],
                              "password_repeat" => [
                                        "matches" => "password",
                                        "required" => true
                              ],
                    ];
                    
                    
                    // Validation des champs
                    if(!Input::check($_POST, $_inputs)) {
                               return false;
                    }
                    
                    $user_ta = Input::post("user_ta");
                    if(Input::post("user_niveau")=="3")  $user_ta = "Free";

                    
                    try {
                        $salt = Hash::generateSalt(32);
                        $userID = self::addUser([
                                "user_email" => Input::post("user_email"),
                                "user_name" => Input::post("user_nom"),
                                "user_level" => Input::post("user_niveau"),
                                "user_tel" => Input::post("user_tel"),
                                "user_ta" => $user_ta,
                                "user_statut" => Input::post("user_statutcompte"),
                                "user_pass" => Hash::generate(Input::post("password"), $salt),
                                "salt" => $salt
                        ]);
                    
                              Flash::success(Text::get("REGISTER_USER_CREATED"));
                              return $userID;
                    } catch (Exception $ex) {
                              Flash::danger($ex->getMessage());
                    }
                    return false;
          }

          public function createUser(array $fields) {
                    $ModelCore = new ModelCore();
                    if (!$userID = $ModelCore->create("utilisateurs", $fields)) {
                            //  print "eeewwwwo";
                              throw new Exception(Text::get("USER_CREATE_EXCEPTION"));
                    }
                    return $userID;
          }

          public function addUser(array $fields) {
                    $ModelCore = new ModelCore();
                    print "deux";
                    if (!$userID = $ModelCore->create("utilisateurs", $fields)) {
                        print "trois";
                              throw new Exception(Text::get("USER_CREATE_EXCEPTION"));
                    }
                    return $userID;
          }

          public function login() {
                    $_inputs = [
                              "email" => [
                                  "filter" => "email",
                                  "required" => true
                              ],
                              "password" => [
                                  "required" => true
                              ]
                    ];
                    
                    if (!Input::check($_POST, $_inputs)) {
                        return false;
                    } 
            
                    $email = Input::post("email");
                    // var_dump($User = $this->getInstance($email));

                    if (!$User = $this->getInstance($email)) {
                    //      print "n'existe pas";
                        Flash::info(Text::get("LOGIN_USER_NOT_FOUND"));
                        return false;
                    }
                    try {
                        $data = $User->data();
                    //          print "son mot de passe".$data->user_pass;
                        $password =Input::post("password");
                    // //     if (Hash::generate($password, $data->salt) !== $data->password) {
                        if (Hash::generate($password, $data->salt) !== $data->user_pass) {
                            throw new Exception(Text::get("LOGIN_INVALID_PASSWORD"));
                        }
            
                        // Se souvenir de moi checkbox.
                        $remember = Input::post("remember") === "on";
                        if ($remember and ! self::createRememberCookie($data->user_id)) {
                            //throw new Exception();
                        }
            
                    //     // J'enregistre les données de sessions lorsque le login est éussi
                        Session::put(Config::get("SESSION_USER"), $data->user_id);
                        return true;
                    } catch (Exception $ex) {
                        Flash::warning($ex->getMessage());
                    }
                    return false;
          }

          public function getInstance($user) {
                   $User = new UserManager();
                   if ($User->findUser($user)->exists()) {
                       return $User;
                   }
                   return null;
          }

          public function findUser($user) {
                    $field = filter_var($user, FILTER_VALIDATE_EMAIL) ? "user_email" : (is_numeric($user) ? "user_id" : "user_name");
                    return($this->find("utilisateurs", [$field, "=", $user]));
          }
          
          // public function updateUser(array $fields, $userID = null) {
          //           if (!$this->update("users", $fields, $userID)) {
          //                     throw new Exception(Utility\Text::get("USER_UPDATE_EXCEPTION"));
          //           }
          // }

        public function loginWithCookie() {

                // Check if a remember me cookie exists.
                if (!Cookie::exists(Config::get("COOKIE_USER"))) {
                    return false;
                }
        
                $Db = DbManager::getInstance();
                $hash = Cookie::get(Config::get("COOKIE_USER"));
                $check = $Db->select("user_cookies", ["hash", "=", $hash]);
                if ($check->count()) {
        
                    // Check if the user exists.
                    $userID = $Db->first()->user_id;
                    if (($User = $this->getInstance($userID))) {
                        $data = $User->data();
                        Session::put(Utility\Config::get("SESSION_USER"), $data->user_id);
                        return true;
                    }
                }
                Cookie::delete(Config::get("COOKIE_USER"));
                return false;
        }

        public static function logout() {
    
            $cookie = Config::get("COOKIE_USER");
            if (Cookie::exists($cookie)) {
                $Db = DbManager::getInstance();
                $hash = Cookie::get($cookie);
                $check = $Db->delete("user_cookies", ["hash", "=", $hash]);
                if ($check->count()) {
                    Cookie::delete($cookie);
                }
            }
    
            Session::destroy();
            return true;
        }
        
        public function getNiveauxUsers(){
            $Db = DbManager::getInstance();
            return $Db->select("niveaux_users")->results();
        }
        
        public function getTA(){
            $Db = DbManager::getInstance();
            return $Db->select("types_abonnement",['id', ">", 1])->results();
        }
        
        public function getUsersList(){
            $Db = DbManager::getInstance();
            return $Db->select("utilisateurs")->results();
        }

 }