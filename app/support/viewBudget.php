<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/ViewBudget.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $catId = $_POST['catId'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  $viewBudget  = new Mir;
  $viewedBudget = $viewBudget->viewBudget($userId, $catId, $month, $year);

  echo $viewedBudget;
  //echo json_encode($year);
  //echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));

}else{
  echo 'error';
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
