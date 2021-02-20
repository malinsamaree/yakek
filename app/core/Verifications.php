<?php
class Verifications{

  //validate email
  public static function validateEmail($email){
    $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $isEmailValid;
  }

  public static function sanitizeEmail($email){
    $sanitizedEmail = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    return $sanitizedEmail;
  }


  //Validate password
   public static function validatePassword($password, $cpassword=NULL){
    $passwordErrMsg = '';
    if (mb_strlen($password) < 8) {
      $passwordErrMsg = 'Password must be at least 8 characters long';
    }else if(mb_strlen($password) > 60){
      $passwordErrMsg = 'Password must be between 8 to 60 characters';
    }else{
      // if ((($cpassword!=NULL) || ($cpassword!='') ) && ($password != $cpassword)) {
      //     $passwordErrMsg =  'Two passwords are not matching';
      // }
      if (($password != $cpassword)) {
          $passwordErrMsg =  'Two passwords are not matching';
      }
    }
    return $passwordErrMsg;
   }

  //encrypt password
  public static function encryptPassword($password){
    $encryptedPassword = sodium_crypto_pwhash_str(
    $password,
    SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
    SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
    );
    return $encryptedPassword;
  }

  //validate password
  public static function verifyPassword($hash, $password){
    if(!$password == ''){
        $isPasswordValid = sodium_crypto_pwhash_str_verify ( $hash , $password);
        return $isPasswordValid;
    }
  }

  //validate string
  public static function sanitizeString($stringVal){
    $sanitizedString = filter_var(trim($stringVal), FILTER_SANITIZE_STRING);
    return $sanitizedString;
  }

  //validate date
  public static function validateDate($dateDate, $dateMonth, $dateYear){
    return checkdate($dateMonth, $dateDate, $dateYear);
  }

  //hashString
  public static function hashString($string){
    $hashedString = bin2hex(sodium_crypto_generichash($string));
    return $hashedString;
  }

  //validate integer
  public static function validateInt($int){
    return filter_var($int, FILTER_VALIDATE_INT);
  }

  // validate floatval
  public static function validateFloat($float){
    return filter_var($float, FILTER_VALIDATE_FLOAT);
  }

  // validate boolean
  public static function validateBoolean($boolean){
    return filter_var($boolean, FILTER_VALIDATE_BOOLEAN);
  }

  //round float
  public static function roundFloat($float){
    return round($float, 2);
  }

}
