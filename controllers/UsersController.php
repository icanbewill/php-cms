<?php
          
        class UsersController extends Controller{
            protected $controller;
            public function process($params)  {
              
              $usersManager = new UserManager();
              if (!empty($params[0])){
                $parsedUrl = $this->parseUrl($params[0]);
                $action = $params[0];
                switch ($action) {
                  case 'logout':
                    $this->logout();
                    break;
                  case 'addnewuser':
                    $this->addnewuser();
                    break;
                  default:
                    // QUEQUE CHOSE
                    break;
                  }
              }
              else {
                
                $this->head = array(
                  'title' => "Liste des utilisateurs",
                  'description' => "Humm",
                );

                $userslist = $usersManager->getUsersList();
                $niveaux_users = $usersManager->getNiveauxUsers();
                $ta = $usersManager->getTA();
                // print_r($ta);
                // $types_modeles = $modeleManager->getTypesFactures();
                // $this->data['modeles'] = $modeles;
                $this->data['niveaux_users'] = $niveaux_users;
                $this->data['ta'] = $ta;
                $this->data['userslist'] = $userslist;
                $this->view = 'Utilisateurs/liste';
              }
              //  $this->head['title'] = 'Modèles de factures';
                // Sets the template
                // $this->view = 'Users/'.$parsedUrl[0];
            }

            private function parseUrl($url){
                $parsedUrl = parse_url($url);
                $parsedUrl['path'] = ltrim($parsedUrl['path'],"/");
                $parsedUrl['path'] = trim($parsedUrl['path']);
                $explodedUrl = explode("/", $parsedUrl["path"]);
                return $explodedUrl;
            }

            public function logout() {
            
                    Auth::checkAuthenticated();
                    if (UserManager::logout()) {
                      Redirect::to("login");
                        $response = array("response" => "Success");
                        echo json_encode($response);
                    }
                    Redirect::to("modeles");
            }

            public function addnewuser() {
              Auth::checkAuthenticated();
               if (UserManager::registeruser()) {
                //  print "oooui";
                  Redirect::to("users");
               }
               print "non";
               Redirect::to("users");
           }
      }
?>