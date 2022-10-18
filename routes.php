<?php
function call($controller, $action)
{
  require_once('controllers/' . $controller . '_controller.php');

  switch ($controller) {
    case 'pages':
      $controller = new PagesController();
      break;
    case 'personnes':
      require_once('models/DAOPersonnes.php');
      require_once('models/Personne.php');
      $controller = new PersonnesController();
      break;
  }

  $controller->{$action}();
}

// j'ajoute ceci pour référencer chaque controlleur et ses actions
$controllers = array(
  'pages' => ['home', 'error'],
  'personnes' => ['index', 'show', 'create']
);

if (array_key_exists($controller, $controllers)) {
  if (in_array($action, $controllers[$controller])) {
    call($controller, $action);
  } else {
    call('pages', 'error');
  }
} else {
  call('pages', 'error');
}
