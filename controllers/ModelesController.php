<?php
        
          class ModelesController extends Controller{
                    
                    protected $controller;
                    public function process($params)  {
                              $modeleManager = new ModelesManager();
                              Auth::checkAuthenticated();
                              if (!empty($params[0])){
                                      $action = $params[0];
                                      switch ($action) {
                                              case 'create':
                                                        $this->createModele();
                                                      break;
                                              case 'savetemplate':
                                                        $this->savetemplate();
                                                      break;
                                              case 'details':
                                                    if(!empty($params[1])){
                                                          if($recup = $this->verifExist($params[1])){
                                                                  $this->data['mod'] = $recup;
                                                          }
                                                          else Redirect::to('error');
                                                        }

                                                        $this->view = 'Modeles/details';
                                                      break;
                                              case 'saveimg':
                                                        $this->saveTemplate();
                                                      break;
                                              case 'template':
                                                        $this->view = 'Modeles/template';
                                                        if(!empty($params[1])){
                                                                if($recup = $this->verifExist($params[1])){
                                                                        // var_dump($recup);
                                                                        $this->data['slug'] = $recup->slug;
                                                                        $this->data['nom_modele'] = $recup->nom_modele;
                                                                        $this->data['niveau_modele'] = $recup->niveau_modele;
                                                                }
                                                                else Redirect::to('error');
                                                        }
                                                      break;
                                              case 'edit':
                                                        // $this->saveImg();
                                                      break;
                                              
                                              default:
                                                      # code...
                                                      break;
                                      }
                                      //$modele = $modeleManager->getModele($params[0]);
                                //       if (!$modele) $this->redirect('error');
                                      

                                //       $this->head = array(
                                //               'title' => $modele['nom_modele'],
                                //               'description' => $modele['slug'],
                                //       );
                      
                                //       // Sets the template variables
                                //       $this->data['title'] = $modele['nom_modele'];
                                //       $this->data['content'] = $modele['contenu'];
                      
                                //       // Sets the template
                                //       $this->view = 'Modeles/details';
                              }
                              else {
                                      
                                        //print "dggegre";
                                        $this->head = array(
                                                  'title' => "Liste des modèles",
                                                  'description' => "Humm",
                                          );

                                      $modeles = $modeleManager->getModelesFactures();
                                      $niveaux_modeles = $modeleManager->getNiveauxFactures();
                                      $types_modeles = $modeleManager->getTypesFactures();
                                      $this->data['modeles'] = $modeles;
                                      $this->data['niveaux_modeles'] = $niveaux_modeles;
                                      $this->data['types_modeles'] = $types_modeles;
                                      $this->view = 'Modeles/liste';
                              }
                      
                }

                public function savetemplate() {
                        echo '<script>console.log("Welcome to GeeksforGeeks!"); </script>';
                        Auth::checkAuthenticated();
                        if (UserManager::logout()) {
                          Redirect::to("login");
                            $response = array("response" => "Success");
                            echo json_encode($response);
                        }
                        Redirect::to("modeles");
                }

                public function createModele(){
                        Auth::checkAuthenticated();
                        if($modID = ModelesManager::createModele()){
                                $Db = DbManager::getInstance();
                                $get = $Db->select("factures_modeles", ["idfactures_modeles", "=", $modID])->first();
                                // var_dump($get);
                                $slug = $get->slug;
                                $this->data['nom_modele'] = $slug;
                                Redirect::to("modeles/template/".$slug);
                        }
                        Redirect::to("modeles");
                }

                public function verifExist($slug){
                        Auth::checkAuthenticated();
                        $Db = DbManager::getInstance();
                        $get = $Db->select("factures_modeles", ["slug", "=", $slug])->count();
                        if($get) return $Db->select("factures_modeles", ["slug", "=", $slug])->first();
                        else return false;
                }

                public function saveTemplatre(){
                        // $image = $_POST["imgdata"];
                        // $image = explode(";", $image)[1];
                        // $image = explode(",", $image)[1];
                        // $image = str_replace(" ", "+", $image);
                        // $image = base64_decode($image);
                        // "user_email" => Input::post("user_email"),
                        // "user_name" => Input::post("nom"),
                        // "u
                        
                        echo '<script>console.log("Welcome to GeeksforGeeks!"); </script>';

                        // console.log("expression");

                        // $Db = DbManager::getInstance();
                        // $Db->update("factures_modeles",'Vdfvdf',["contenu"=> "ouep"]);
                        // return json_encode('value');
                        // var_dump($image);
                        // print "<script>alert('hello')</script>";
                        // file_put_contents("filename.jpeg", $image);
                        // echo "Done";

                        // $file = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$filename.'.png';
                        // $imageurl  = 'http://example.com/uploads/'.$filename.'.png';
                        // file_put_contents($file,$imagedata);
                }
        }
?>