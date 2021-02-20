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

if (isset($_POST['email'])) {
  $unknownErr = 0;
  $loggedIn = 0;
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $pass2 = $_POST['cpassword'];
  if(isset($_POST['keepLogged'])){
    $loggedIn = 1;
  }

  //$tempPass1 = 'malinmalin';
  //$tempPass2 = 'malinmalin';

  $user = new User;
  $registed = $user->addUser($email, $pass, $pass2);
  //$registed = $user->addUser($email, $tempPass1, $tempPass2);
  //var_dump($registed);
  if (isset($registed) && $registed == 'success') {
    $loggedUser = $user->loginUser($email, $pass, $loggedIn);
    //$loggedUser = $user->loginUser($email, $tempPass1, $loggedIn);

    if(isset($loggedUser['default']) && $loggedUser['default'] == 'good'){
      $userIdNew = $_SESSION['user_id'];
      $addInitCats = $user->addInitCats($userIdNew);
      if ($addInitCats == false) {
        header('location:../mir');
      }else{
        //delete the user
        $unknownErr = 1;
      }
        //header('location:../mir');
    }else {
      $unknownErr = 1;
    }
    //var_dump($loggedUser['default']);
    //var_dump($_SESSION);
    //var_dump($_COOKIE);
    //echo $userIdNew;
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/login.js"></script>

    <link rel="stylesheet" href="../css/newuser.css">

    <link rel="apple-touch-icon" sizes="144x144" href="../images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicons/favicon-16x16.png">
    <link rel="manifest" href="../images/favicons/site.webmanifest">
    <link rel="mask-icon" href="../images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

  </head>
  <body>
    <div class="nu_mainContainer">
      <div class="nu_mainContainer_inner">
        <!-- <div class="nu_header">
          <img src="../images/logo.png" alt="">
        </div> -->
        <div class="nu_content">
          <div class="nu_contentInner">
            <div class="nu_contentLogo">
              <img src="../images/logo.png" alt="">
            </div>
            <div class="nu_contentHeading">
              Register
            </div>
            <div class="nu_errorDisplay">
              <?php
                if (isset($registed['emailErr'])) {
                  echo 'Error: ' . $registed['emailErr'];
                }elseif (isset($registed['passwordErr'])) {
                  echo 'Error: ' . $registed['passwordErr'];
                }elseif (isset($registed) && $registed == 'error') {
                  echo 'Error: unknown. registration unsuccesful';
                }//elseif (isset($unknownErr) && $unknownErr == 1) {
                //   echo 'Error: unknown';
                // }
              ?>
            </div>
            <div class="nu_contentForm">
              <form class="" action="" method="post">
                <input type="email" name="email" value="" placeholder="email"><br>
                <input type="password" name="password" value="" placeholder="password"><br>
                <input type="password" name="cpassword" value="" placeholder="reenter password"><br>
                <div class="nu_contentFormKeepLogged">
                  <input type="checkbox" name="keepLogged" value="" checked>
                  Remember me
                </div>
                <div class="nu_contentFormSubmit">
                  <input type="submit" name="" value="register">
                </div>
              </form>
            </div>
            <div class="nu_contentExtra">
              <div class="nu_contentExtra1">
                You are agreeing to <a href="#">Terms and Conditions</a> and <a href="#">privacy policy</a> of yakek.com by clicking the 'Register button'
              </div>
              <div class="nu_contentExtra2">
                Already registered? <a href="../user/login">Login here</a>
              </div>
            </div>
            <div class="legalTexts">
              <span class="legalTextsImprint">Imprint</span>
              <span class="legalTextsTac">Terms and conditions</span>
              <span class="legalTextsPp">Privacy policy</span>
            </div>
            <div class="imprint aLegalText">
              <?php include 'app/views/texts/imprint.html' ?>
              <div class="imprintClose aLegalTextClose">
                Close
              </div>
            </div>
            <div class="tac aLegalText">
              terms and conditions
              <div class="tacClose aLegalTextClose">
                Close
              </div>
            </div>
            <div class="pp aLegalText">
              privacy policy
              <div class="ppClose aLegalTextClose">
                Close
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
