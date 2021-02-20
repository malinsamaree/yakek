<?php
  session_start();
  //var_dump(LoginAssist::isLoggedIn());
  //var_dump($_SESSION);

  echo 'laskjd . <br>';
  //echo $_SERVER['PHP_SELF'];

  if(isset($_SESSION['user_id'])){
    header('location:mir');
  }else{
    header('location:user/');
  }
?>
