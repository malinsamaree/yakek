<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/ChangeCat.php';
if(isset($_POST)){
  $userId =$_POST['userId'];
  $catId = $_POST['catId'];
  $month = $_POST['month'];
  $year = $_POST['year'];


  $changeCat = new Mir;
  $changedCatt = $changeCat->changeCategory($userId, $catId, $month, $year);

  //$changedCatt = ['catId' => $catId, 'userId' => $userId];
  //echo json_encode('maon');
  echo json_encode($changedCatt);
}else{
  echo json_encode(['err'=>'err']);
}
//
// $addTransaction  = new Mir;
// $addTransaction->addTransaction($userId, $catId, $amount, $date, $note);

?>
