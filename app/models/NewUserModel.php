<?php
class NewUserModel{
  private $email;
  private $password;
  private $firstName;
  private $lastName;
  private $dob;
  private $isEmailValidated;
  private $error = false;
  private $errMsg = [];

  public function addNewUser($email, $password, $cpassword = NULL, $firstName=NULL, $lastName=NULL, $dob=NULL, $isEmailValidated=0){

    //validate email
    if(Verifications::validateEmail($email) == false){
      $this->error = true;
      $this->errMsg += ['emailErr' => 'Invalid Email'];
    }else{
      $sanitizedEmail = Verifications::sanitizeEmail($email);
      $dbQueryResult = Database::selectQuery("SELECT email FROM users WHERE email=:email", ['email'=>$sanitizedEmail]);
      if (!empty($dbQueryResult)) {
        $this->error = true;
        $this->errMsg += ['emailErr' => 'This email is already registered'];
      }else {
        $this->email = $sanitizedEmail;
      }
    }

    //validate password
    if(Verifications::validatePassword($password, $cpassword) != ''){
      $this->error = true;
      $this->errMsg  += ['passwordErr' => Verifications::validatePassword($password, $cpassword)];
    }else{
      $this->password = Verifications::encryptPassword($password);
    }

    //validate first name
    if($firstName != '' || $firstName != NULL){
      $this->firstName = Verifications::sanitizeString($firstName);
    }else {
      $this->firstName = NULL;
    }

    //validate last name
    if($lastName != '' || $lastName != NULL){
      $this->lastName = Verifications::sanitizeString($lastName);
    }else {
      $this->lastName = NULL;
    }

    //validate date
    if($dob != '' || $dob != NULL){
      $this->dob = Verifications::validateDate($dob);
    }else {
      $this->dob = NULL;
    }
    //$isPasswordValid = Verifications::validatePassword($password_enc, $this->password);

    if(!$this->error){
      if(Database::insertQuery("INSERT INTO users (email, password, first_name, last_name, dob, is_email_validated) VALUES (:email, :password, :firstName, :lastName, :dob, :isEmailValidated)", ['email'=>$this->email, 'password'=>$this->password, 'firstName'=>$this->firstName, 'lastName'=>$this->lastName, 'dob'=>$this->dob, 'isEmailValidated'=>1])){
        //return $userInsertId;
        return 'success';
        //send validation email here
      }else{
        return 'erRor';
      }
    }else{
      return $this->errMsg;
      //return 'success';
    }
  }
}
