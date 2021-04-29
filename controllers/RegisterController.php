<?php
   
          class RegisterController extends Controller{
                    public function process($params){
                              $this->head['title'] = 'Enregistrement';
                              $this->head['description'] = 'Hello que passa ?';
                            //   $Auth = 'config/Auth';
                              Auth::checkUnauthenticated();
                             $this->view = 'Public/register';
                              if (!empty($params[0]) && $params[0]=="register") {
                                      $this->register();
                              }
                    }
                    
                    public function register() {
                             Auth::checkUnauthenticated();
                          //   $UserManager = new UserManager();
                             
                              if (UserManager::register()) {
                                        // print "hhum";
                                 Redirect::to("login");
                              }
                              Redirect::to("register");
                          }
                  
          }