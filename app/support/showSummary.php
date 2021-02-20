<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/ShowSummary.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  $showSummary  = new Mir;
  $showedSummary = $showSummary->showSummary($userId, $month, $year);

  echo $showedSummary;
  //echo $viewedTransactions;
  //echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));

}else{
  echo 'error';
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
