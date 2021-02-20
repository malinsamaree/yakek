<?php
class ChangePassModel{
  private $errors = false;
  private $errMsg = [];
  private $finalPassword;


  public function changePassword($userId, $curPassword, $newPassword, $newPassword2){
    $enctedPass = Database::selectQuery('SELECT password FROM users WHERE id=:id', ['id'=>$userId]);
    $isCurPassCorrect = Verifications::verifyPassword($enctedPass[0]['password'], $curPassword);
    if($isCurPassCorrect){
      if(Verifications::validatePassword($newPassword, $newPassword2) == ''){
        $this->finalPassword = Verifications::encryptPassword($newPassword);
        if (Database::updateQuery("UPDATE users SET password=:password WHERE id=:id", ['password'=>$this->finalPassword, 'id'=>$userId])) {
          // code...
        }else{
            $this->errors = true;
            $this->errMsg  += ['connectionErr'=>'Some error occured'];
        }
      }else{
        $this->errors = true;
        $this->errMsg  += ['passwordErr' => Verifications::validatePassword($newPassword, $newPassword2)];
      }
    }else{
      $this->errors = true;
      $this->errMsg += ['curPassErr'=>'Incorrect login password'];
    }

    $defaultErr;
    if($this->errors){
      $defaultErr = 'yes';
    }else{
      $defaultErr = 'no';
    }
    $this->errMsg  += ['default'=>$defaultErr];


    return $this->errMsg;
  }

}
