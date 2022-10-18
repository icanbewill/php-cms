<?php
  class PagesController {
    public function home() {
      $first_name = 'WILFRZND';
      $last_name  = 'HAH';
      require_once('views/pages/home.php');
    }

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>