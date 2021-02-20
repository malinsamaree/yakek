<?php
session_start();

$passwordError = '';

if (!isset($_SESSION['user_id'])) {
  header('location:../login');
}else{
  if(isset($_POST['passwordCur'])){
    $curPassword = $_POST['passwordCur'];
    $newPassword = $_POST['newPassword'];
    $newPassword2 = $_POST['newPassword2'];


    $user = new User();
    $returned =  $user->changePass($_SESSION['user_id'], $curPassword, $newPassword, $newPassword2);
    var_dump($returned);
      if ($returned['default'] == 'yes') {
        $passwordError = 'Error occured, Please try again';
      }
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
    <script src="../js/changepw.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../css/changepw.css">
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
        <div class="content">
          <div class="loginDiv">
            <div class="loginDivLogo">
              <img src="../images/logo.png" alt="">
            </div>

            <?php
            if (!isset($_POST['passwordCur']) || $passwordError != '') {
            ?>
            <div class="loginDivHeading">
              Change password
            </div>
            <div class="pwErr">
              <?php echo $passwordError;?>
            </div>
            <div class="loginDivContent">
              <form class="" action="" method="post">
                <input type="password" name="passwordCur" value="" placeholder="current password"><br>
                <input type="password" name="newPassword" value="" placeholder="new password"><br>
                <input type="password" name="newPassword2" value="" placeholder="confirm new password"><br>
                <div class="loginSubmitBtn">
                  <input type="submit" name="submit" value="change">
                  <div class="cancel">
                    <a href="../mir">cancel <i class="material-icons"> home</i></a>
                  </div>
                </div>
              </form>
            </div>
            <?php
          }else {
            ?>
            <div class="passChangeSuccess">
              <div class="passChangeSuccessMsg">
                Password changed successfully
              </div>
              <div class="passChangeSuccessHome">
                <a href="../mir">
                <i class="material-icons">keyboard_backspace</i>Back to home
                </a>
              </div>
            </div>
            <?php
          }
            ?>

            <div class="legalTexts">
              <div class="legalTextsInner">
                <div class="legalTextsLinks">
                    <a href="../texts/imprint">imprint</a>
                    <a href="../texts/tac">terms & conditions</a>
                    <a href="../texts/pp">privacy policy</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
