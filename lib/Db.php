<?php

class Db
{
  private static $pdo = null;

  public static function getInstance() {
    if (is_null(self::$pdo)) {
      self::$pdo = new PDO(sprintf(
        '%s:host=%s; port=%d; dbname=%s; charset=utf8;'
        , 'mysql'
        , 'localhost'
        , 3306
        , 'cat'
      ), 'cat', 'cat');

      self::$pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    return self::$pdo;
  }
}
