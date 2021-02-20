<?php
session_start();
if(isset($_SESSION['user_id'])){
  header('location:../mir');
}else{
  if (LoginAssist::isLoggedIn()['loggedIn'] == false) {
    header('location:login');
  }else{
    $userId = intval(LoginAssist::isLoggedIn()['userId'][0]['user_id']);
    if(!$userId == 0){
      echo $userId;
      $_SESSION['user_id'] = $userId;
      header('location:../mir');
    }
    else{
      echo '0';
      //header('location:login');
    }
  }
  //var_dump(LoginAssist::isLoggedIn()['userId'][0]['user_id']);
}


//var_dump($_COOKIE);
//var_dump(LoginAssist::isLoggedIn());
//echo 'Success<br>';
?>
