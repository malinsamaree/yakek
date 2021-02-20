<?php
session_start();
if(isset($_SESSION['user_id'])){
  unset($_SESSION['user_id']);
}
if (isset($_COOKIE['ULC'])) {
  Database::deleteQuery("DELETE FROM tokens WHERE token=:token", ['token'=>bin2hex(sodium_crypto_generichash($_COOKIE['ULC']))]);
  setcookie('ULC', 'a', time()-3600);
}
if (isset($_COOKIE['ULC_'])) {
  Database::deleteQuery("DELETE FROM tokens WHERE token=:token", ['token'=>bin2hex(sodium_crypto_generichash($_COOKIE['ULC_']))]);
  setcookie('ULC_', 'a', time()-3600);
}
header('location: ../user/login');
