<?php
class PersonsController
{
  public function index()
  {
    $persons = ListPersons::getPersons();
    require_once('views/person/index.php');
  }

  public function show()
  {
    if (!isset($_GET['id']))
      return call('pages', 'error');

    // we use the given id to get the right post
    $post = Post::find($_GET['id']);
    require_once('views/persons/show.php');
  }
}
