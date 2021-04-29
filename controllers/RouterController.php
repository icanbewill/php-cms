<?php

class RouterController extends Controller{

          protected $controller;
          public function process($params){
                    
                    $parsedUrl = $this->parseUrl($params[0]);
                    if (empty($parsedUrl[0])) $this->redirect('Modeles/liste');

                    $controllerClass = $this->dashesToCamel(array_shift($parsedUrl)) . 'Controller';
                    //  print_r($controllerClass);

                    if (file_exists('controllers/' . $controllerClass . '.php')) $this->controller = new $controllerClass;
                    else Redirect::to('error');
                    $this->controller->process($parsedUrl);

                    $this->data['title'] = $this->controller->head['title'];
                    $this->data['description'] = $this->controller->head['description'];
                    
                    $vue  = Auth::decideView();

                    // //tatonnement -- doit faire plus de contrôle ici
                    // if($parsedUrl[0]=="template")$this->view = 'Modeles/template'; 
                    // else{
                    if($vue) $this->view = 'layout';
                    else $this->view = 'home';
          // }
          }

          //Je recupère l'URL 
          private function parseUrl($url){
                    $parsedUrl = parse_url($url);
                    $parsedUrl['path'] = ltrim($parsedUrl['path'],"/");
                    $parsedUrl['path'] = trim($parsedUrl['path']);
                    $explodedUrl = explode("/", $parsedUrl["path"]);
                    return $explodedUrl;
          }

          //Transformation
          public function dashesToCamel($text){
                    $text = str_replace('-', ' ', $text);
                    $text = ucwords($text);
                    $text = str_replace(' ', '', $text);
                    return $text;
          }
}