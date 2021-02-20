<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/DisplayCalandar.php';
if(isset($_POST)){
  $month = $_POST['month'];
  $year = $_POST['year'];
  $but = $_POST['but'];

  $displayCalandar  = new Mir;
  $displayedCalandar = $displayCalandar->displayCalandar($month, $year, $but);

  echo $displayedCalandar;
  //echo json_encode($year);
  //echo($addTransaction->addTransaction($userId, $catId, $amount, $date, $note, $expense));

}else{
  echo 'error';
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
