<?php
class PersonnesController
{
  public function index()
  {
    $personnes = DAOPersonnes::all();
    require_once('views/personnes/index.php');
  }

  public function create()
  {
    require_once('views/personnes/create.php');
  }

  public function show()
  {
    if (!isset($_GET['id']))
      return call('pages', 'error');
    $personne = DAOPersonnes::find($_GET['id']);
    require_once('views/personnes/show.php');
  }
}
