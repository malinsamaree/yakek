<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/ShowMonthlySummary.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  $showMonthlySummary  = new Mir;
  $showedMonthlySummary = $showMonthlySummary->showMonthlySummary($userId, $month, $year);

  //echo $viewedBudget;
  echo $showedMonthlySummary;
  //echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));
  //echo 'asd';
}else{
  echo 'error';
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
