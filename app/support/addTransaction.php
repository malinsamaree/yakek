<?php
require_once '../init.php';
//require_once '../core/Controller.php';
require_once '../controllers/mir.php';
require_once '../models/AddTransaction.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $catId = $_POST['catId'];
  $amount = $_POST['amount'];
  $date = $_POST['date'];
  $note = $_POST['note'];
  $expense = $_POST['expense'];
  //echo $expense;
  $addTransaction  = new Mir;
  echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));

}else{
  echo 'error';
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
