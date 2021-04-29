<?php

class  ModelesManager extends ModelCore{

        public function createModele(){
                $_inputs = [
                        "nom_modele" => [
                                  "required" => true
                        ],
                        "niveau_modele" => [
                                  "required" => true
                        ]
              ];

            
                $check = $_POST['checktypes'];
                $checkjs = json_encode($check);

              // Validation des champs
              if(!Input::check($_POST, $_inputs) || empty($check)) {
                         return false;
              }

              try {
                        $modID = self::createModData([
                                  "nom_modele" => Input::post("nom_modele"),
                                  "niveau_modele" => Input::post("niveau_modele"),
                                  "type_modele" => $checkjs,
                                  "addby_modele" => Session::get(Config::get("SESSION_USER")),
                                  "slug" => RouterController::dashesToCamel(Input::post("nom_modele"))
                        ]);

                        //revoir ici
                        Flash::success(Text::get("REGISTER_MODEL_CREATED"));
                        return $modID;
              } catch (Exception $ex) {
                        Flash::danger($ex->getMessage());
              }
              return false;
        }

        public function createModData(array $fields) {
                $ModelCore = new ModelCore();
                if (!$modID = $ModelCore->create("factures_modeles", $fields)) {
                          throw new Exception(Text::get("MODEL_CREATE_EXCEPTION"));
                }

                return $modID;
      }
        
        // $hash = Cookie::get(Config::get("COOKIE_USER"));
        // $check = $Db->select("user_cookies", ["hash", "=", $hash]);

        public function getModelesFactures() {
                $Db = DbManager::getInstance();
               return $Db->select("factures_modeles")->results();
                // var_dump( $modeles);
        }

        public function getNiveauxFactures(){
                $Db = DbManager::getInstance();
                return $Db->select("niveaux_modeles")->results();
        }

        public function getTypesFactures(){
                $Db = DbManager::getInstance();
                return $Db->select("types_modeles")->results();
        }

}