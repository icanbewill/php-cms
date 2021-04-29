<?php
          class LoginController extends Controller{

              public function process($params){
                $this->head['title'] = 'Connexion';
                $this->head['description'] = 'Hello que passa ?';
                $Auth = 'config/Auth';
                Auth::checkUnauthenticated();
                $this->view = 'Public/login';
                if (!empty($params[0])) {
                  switch ($params[0]) {
                    case 'login':
                      $this->login();
                      break;
                    case 'logout':
                      $this->logout();
                      break;
                    default:
                    $this->login();
                      break;
                  }
                }
              }
                    
                  
              public function login() {
                  Auth::checkUnauthenticated();
                  $UserManager = new UserManager();
                  if ($UserManager->login()) {
                     Redirect::to("modeles");
                  }
                   Redirect::to("login");
              }
                    
          
            public function _loginWithCookie() {
            
                      // Check that the user is unauthenticated.
                      Auth::checkUnauthenticated();
            
                      // Process the login with cookie request, redirecting to the home
                      // controller if successful or back to the login controller if not.
                      if (Model\UserLogin::loginWithCookie()) {
                      Utility\Redirect::to(APP_URL);
                      }
                      Utility\Redirect::to(APP_URL . "login");
            }
    
              public function logout() {
                    Auth::checkAuthenticated();
                    if (UserManager::logout()) {
                      Redirect::to("login");
                    }
                    Redirect::to("login");
                }
      }