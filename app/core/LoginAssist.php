<?php
class LoginAssist{

  public static function isLoggedIn(){
    $userId=0;
    $loggedIn = false;
    if (isset($_COOKIE['ULC'])) {
      $userId = Database::selectQuery("SELECT user_id FROM tokens WHERE token=:token", ['token'=>Verifications::hashString($_COOKIE['ULC'])]);
      if (!empty($userId)){
        $loggedIn = true;
        $userId == $userId[0]['user_id'];
        if (!isset($_COOKIE['ULC_'])) {
          self::deleteMainCookie();
          self::createMainCookie($userId[0]['user_id']);
          self::createSecondaryCookie($userId[0]['user_id']);
        }
      }
    }

    return ['loggedIn'=>$loggedIn, 'userId'=>$userId];

  }

  public static function createMainCookie($userId){
    $rawToken = bin2hex(random_bytes(64));
    $token = Verifications::hashString($rawToken);
    Database::insertQuery("INSERT INTO tokens (token, user_id) VALUES (:token, :user_id)", ['token'=>$token,'user_id'=>$userId]);
    setcookie('ULC', $rawToken, time()+(60*60*24*30));
  }

  public static function createSecondaryCookie($userId){
    $rawToken_ = bin2hex(random_bytes(64));
    $token_ = Verifications::hashString($rawToken_);
    Database::insertQuery("INSERT INTO tokens (token, user_id) VALUES (:token, :user_id)", ['token'=>$token_,'user_id'=>$userId]);
    setcookie('ULC_', $rawToken_, time()+(60*60*24*15));
  }

  public static function deleteMainCookie(){
    Database::deleteQuery("DELETE FROM tokens WHERE token=:token", ['token'=>Verifications::hashString($_COOKIE['ULC'])]);
    setcookie('ULC', '', time() - 3600);
  }

  public static function deleteSecondaryCookie(){
    Database::deleteQuery("DELETE FROM tokens WHERE token=:token", ['token'=>Verifications::hashString($_COOKIE['ULC_'])]);
    setcookie('ULC_', '', time() - 3600);
  }

}
