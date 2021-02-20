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
$email = $_POST['email'];
$pass =  $_POST['password'];
$keepLogged = 0;
if (isset($_POST['keepLogged'])) {
  $keepLogged = 1;
}

$user = new User;
$responseArr = $user->loginUser($email, $pass, $keepLogged);

if(isset($responseArr['default']) && $responseArr['default']=='good'){
  header('location:../mir');
}

}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/login.js"></script>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="apple-touch-icon" sizes="144x144" href="../images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicons/favicon-16x16.png">
    <link rel="manifest" href="../images/favicons/site.webmanifest">
    <link rel="mask-icon" href="../images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
  </head>
  <body>
    <div class="mainContainer">
      <div class="mainContainerInner">
        <!-- <div class="header">
          <img src="../images/logo.png" alt="">
        </div> -->
        <div class="content">
          <div class="loginDiv">
            <div class="loginDivLogo">
              <img src="../images/logo.png" alt="">
            </div>
            <div class="loginDivHeading">
              Login
            </div>
            <div class="loginErr">
              <?php if (isset($responseArr['validErr']))
              {
              ?>
                Error: <span><?php echo $responseArr['validErr'] ?></span>
              <?php
              }
              if (isset($responseArr['default']) && $responseArr['default']=='bad' && isset($responseArr['inputErr'])) {
              ?>
                Error: <span>Incorrect login data, Please check your email and password</span>
              <?php
              }
              ?>


            </div>
            <div class="loginDivContent">
              <form class="" action="" method="post">
                <input type="email" name="email" value="" placeholder="email"><br>
                <input type="password" name="password" value="" placeholder="password"><br>
                <div class="loginCkeckBox">
                  <input type="checkbox" name="keepLogged" value="1" checked>Keep me logged in <br>
                </div>
                <div class="loginSubmitBtn">
                  <input type="submit" name="submit" value="login">
                </div>
              </form>
            </div>
            <div class="registerPageLink">
              Not registered yet? <a href="../user/new">register here</a>
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
