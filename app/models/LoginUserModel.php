<?php
class LoginUserModel{
  private $error = false;
  private $errMsg = [];
  private $loggedIn = false;

  public function loginUser($email, $password, $keepLogged){
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
    //validate email
    if(Verifications::validateEmail($email) == false){
      $this->error = true;
      $this->errMsg += ['emailErr' => 'Invalid Email'];
    }else {
      $sanitizedEmail = Verifications::sanitizeEmail($email);
      if($userEmail = Database::selectQuery("SELECT id, email FROM users WHERE email=:email", ['email'=>$sanitizedEmail])){
        if (!empty($userEmail)) {
          if ($encPassword = Database::selectQuery("SELECT password, is_email_validated FROM users WHERE email=:email", ['email'=>$userEmail[0]['email']])) {
            $isPasswordCorrect = Verifications::verifyPassword($encPassword[0]['password'], $password);
            if ($isPasswordCorrect) {
              if ($encPassword[0]['is_email_validated']==1) {
                  if ($keepLogged == 1) {
                    $userId = $userEmail[0]['id'];
                    LoginAssist::createMainCookie($userId);
                    LoginAssist::createSecondaryCookie($userId);
                  }
                  $_SESSION['user_id']=$userEmail[0]['id'];
              }else{
                $this->error = true;
                $this->errMsg += ['validErr' => 'Your email is not validated. Please ckeck the validation email sent to your email address'];
              }
            }else {
              $this->error = true;
              $this->errMsg += ['inputErr' => 'Login failed, Invalid password'];
            }
          }else {
            $this->error = true;
            $this->errMsg += ['inputErr' => 'Login failed, Invalid password'];
          }

        }else {
          $this->error = true;
          $this->errMsg += ['inputErr' => 'Login failed, This email is not registered'];
        }
      }else {
        $this->error = true;
        $this->errMsg += ['inputErr' => 'Login failed, This email is not registered'];
      }
    }
    if($this->error){
      $this->errMsg += ['default' => 'bad'];
    } else{
      $this->errMsg += ['default' => 'good'];
    }
    return $this->errMsg;
    //return $this->loggedIn;
  }
}
