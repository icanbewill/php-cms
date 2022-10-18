<p>Here is a list of all popple:</p>

<?php foreach ($persons as $person) { ?>
  <p>
    <?php echo $person->author; ?>
    <a href='?controller=persons&action=show&id=<?php echo $person->id; ?>'>See content</a>
  </p>
<?php } ?>