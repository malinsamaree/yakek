<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/DeleteTransactions.php';
if(isset($_POST)){
  $transactionId = $_POST['transactionId'];

  $deleteTransactions  = new Mir;
  $deletedTransactions = $deleteTransactions->deleteTransactions($transactionId);

  echo $deletedTransactions;
  //echo $viewedTransactions;
  //echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));

}else{
  echo 'error';
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
