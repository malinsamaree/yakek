<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/ShowCatList.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $expense = $_POST['expense'];

  $showCatList = new Mir;
  $showedCatList= $showCatList->showCatList($userId, $expense);

  echo $showedCatList;
}else{
  echo 'err';
}
