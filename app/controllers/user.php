<?php
class User extends Controller{
  public function index(){
    $this->view('user/index');
  }

  public function new(){
    $this->view('user/newuserform');
  }

  public function login(){
    $this->view('user/loginuserform');
  }

  public function logoff(){
    $this->view('user/logoffuser');
  }

  public function changepw(){
    $this->view('user/changepw');
  }

  public function addUser($email, $password, $cpassword=NULL, $firstName=NULL, $lastName=NULL, $dob=NULL, $isEmailValidated=0){
    $user = $this->model('NewUserModel');
    $newUser = $user->addNewUser($email, $password, $cpassword, $firstName, $lastName, $dob, $isEmailValidated);
    return $newUser;
  }

  public function addInitCats($userIdNew){
    $addInitCats = $this->model('AddInitCats');
    $addedInitCats = $addInitCats->AddInitCategories($userIdNew);
    return $addedInitCats;
  }

  public function loginUser($email, $password, $keepLogged){
    $user = $this->model('LoginUserModel');
    $loginUser = $user->loginUser($email, $password, $keepLogged);
    return $loginUser;
  }

  public function logoffUser($userId){
    $user = $this->model('logoffUserModel');
    $logoffUser = $user->logoffUser($userId);
    return $logoffUser;
  }

  public function changePass($userId, $curPassword, $newPassword, $newPassword2){
    $user = $this->model('changePassModel');
    $changePassUser = $user->changePassword($userId, $curPassword, $newPassword, $newPassword2);
    return $changePassUser;

  }


}
