<?php
class LogoffUserModel{
  public function logoffUser($userId){
    if(isset($_SESSION['user_id'])){
      unset($_SESSION['user_id']);
    }
    if (isset($_COOKIE['ULC'])) {
      LoginAssist::deleteMainCookie();
    }
    if (isset($_COOKIE['ULC_'])) {
      LoginAssist::deleteSecondaryCookie();
    }
    return 'user logged off';
  }
}
