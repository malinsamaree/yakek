<?php
class DatabaseHF{
  public static $host = 'localhost';
  public static $dbName = 'yakek';
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

  public static function insertQueryLIID($params = array()) {
    $conn = new mysqli(self::$host, self::$usename, self::$password, self::$dbName);
    if ($conn->connect_errno) {
        return 'err';
    }else{
        $query = "INSERT INTO categories (user_id, name, icon, color, type) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('isssi', $params[1], $params[2], $params[3], $params[4], $params[5]);
        $id = $params[0];
        if ($stmt->execute()) {
          return $stmt->insert_id;
        }
    }
  }

  public static function lastInsertIdHere(){
    return self::connect()->lastInsertId();
    //return 'test';
  }

  public static function updateQuery($query, $params = array()){
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

  public static function addInitCats($userIdNew){
    $err = false;
    $test = array();
    $query1 = "SELECT * FROM default_categories";
    $stmt1 = self::connect()->prepare($query1);
    $stmt1->execute();
    $data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    if($stmt1->execute()){
      $data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
      foreach ($data as $row) {
        $params = array('userId'=>$userIdNew, 'name'=>$row['name'], 'icon'=>$row['icon'], 'color'=>$row['color'], 'type'=>$row['type'], 'isHidden'=>0);
        $query2 = "INSERT INTO categories (user_id, name, icon, color, type, is_hidden) VALUES (:userId, :name, :icon, :color, :type, :isHidden)";
        $stmt2 = self::connect()->prepare($query2);
        if ($stmt2->execute($params)) {
          $err = false;
        }else{
          $err = true;
        }
      }
    }else {
      $err = true;
    }
    return $err;
  }

}
