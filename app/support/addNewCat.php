<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/AddNewCat.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $expense = $_POST['expense'];
  $icon = $_POST['icon'];
  $color = $_POST['color'];
  $name = $_POST['name'];

  $addNewCat = new Mir;
  $addedNewCat= $addNewCat->addNewCat($userId, $expense, $icon, $color, $name);
  //echo $showedNewCatIcons;
  echo $addedNewCat;
  //echo 'err';
}else{
  echo 'err';
}
