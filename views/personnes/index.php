<header>
  <a href='?controller=personnes&action=create'>Ajouter une personne</a>
</header>
<br>
<p>Liste des personnes</p>


<table>
  <tr>
    <th>Nom</th>
    <th>Sexe</th>
    <th>Action</th>
  </tr>
  <?php foreach ($personnes as $personne) { ?>
    <tr>
      <td> <?php echo $personne->getName(); ?></td>
      <td> <?php echo $personne->getSex(); ?></td>
      <td><a href='?controller=personnes&action=show&id=<?php echo $personne->getId(); ?>'>Voir</a></td>
    </tr>
  <?php } ?>
</table>