<?php
require_once '../init.php';
require_once '../controllers/mir.php';
require_once '../models/ShowNewCatIcons.php';
if(isset($_POST)){
  $userId = $_POST['userId'];
  $expense = $_POST['expense'];

  $showNewCatIcons = new Mir;
  $showedNewCatIcons= $showNewCatIcons->showNewCatIcons($userId, $expense);
  echo $showedNewCatIcons;

}else{
  echo 'err';
}
