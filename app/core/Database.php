<?php
class Database{
  public static $host = 'localhost';
  public static $dbName = 'yakek_users';
  public static $usename = 'root';
  public static $password = '';


  private static function connect() {
    $pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbName.";charset=utf8", self::$usename, self::$password);
    //$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

  public static function selectQuery($query, $params = array()) {
    $stmt = self::connect()->prepare($query);
    $stmt->execute($params);
    if (explode(' ', $query)[0] == 'SELECT') {
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $data;
    }
  }

  public static function insertQuery($query, $params = array()) {
    $stmt = self::connect()->prepare($query);
    if ($stmt->execute($params)) {
      return true;
    }
  }

  public static function deleteQuery($query, $params = array()) {
    $stmt = self::connect()->prepare($query);
    if ($stmt->execute($params)) {
      return true;
    }
  }

  public static function updateQuery($query, $params = array()) {
    $stmt = self::connect()->prepare($query);
    if ($stmt->execute($params)) {
      return true;
    }
  }


}
