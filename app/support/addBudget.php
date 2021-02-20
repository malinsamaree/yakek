<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/AddBudget.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $catId = $_POST['catId'];
  $budget = $_POST['budget'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  $addBudget  = new Mir;
  $addedBudget = $addBudget->addBudget($userId, $catId, $budget, $month, $year);
  //echo json_encode($month);
  echo $addedBudget;
  //echo $viewedBudget;
  //echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));

}else{
  echo json_encode('error');
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
