<?php
  include_once(dirname(__FILE__)."/Db.php");

  $dbh = \Db::getInstance();
  $dbh->beginTransaction();
  $sth = $dbh->prepare("SELECT * FROM images");
  $sth->execute();
  $dbh->commit();

  while ($image = $sth->fetchObject()) {
    $images[] = $image;
  }
  echo(json_encode($images));
?>
