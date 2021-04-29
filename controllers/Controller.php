<?php
  abstract class Controller{
      //donnees
      protected $data = array();
      protected $view = "";
      protected $head = array('title' => '', 'description' => '');
  
      //fonctions
      abstract function process($params);

      public function renderView(){
            if ($this->view){
                  extract($this->protect($this->data));
                  extract($this->data, EXTR_PREFIX_ALL, "");
                  require("vues/" . $this->view . ".phtml");
            }
      }

      //Fonction de redirection
      public function redirect($url){
            header("Location: /$url");
            header("Connection: close");
            exit;
      }

      // Je protège les variables ici
      private function protect($x = null) {
            if (!isset($x)) return null;
            elseif (is_string($x)) return htmlspecialchars($x, ENT_QUOTES);
            elseif (is_array($x)){
                  foreach($x as $k => $v){
                        $x[$k] = $this->protect($v);
                  }
                  return $x;
            }else return $x;
      }
  }