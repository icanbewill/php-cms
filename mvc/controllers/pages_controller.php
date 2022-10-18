<?php
  class PagesController {
    public function home() {
      $first_name = 'Wi';
      $last_name  = 'Wi';
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>