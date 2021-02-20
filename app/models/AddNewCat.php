<?php
class AddNewCat{

  private $userId;
  private $expense;
  private $icon;
  private $color;
  private $name;

  public function addTheNewCat($userId, $expense, $icon, $color, $name){
    $err = false;

    if (!empty(Verifications::validateInt($userId))) {
      $this->userId = $userId;
    }else{
      $err = true;
    }

    if($expense == 'true'){
      $this->expense = 1;
    }elseif($expense == 'false'){
      $this->expense = 0;
    }else{
      $err = true;
    }

    if (!$icon == '') {
      $this->icon = Verifications::sanitizeString($icon);
    }else{
      $err = true;
    }

    if (!$color == '') {
      $this->color = Verifications::sanitizeString($color);
    }else{
      $err = true;
    }

    if (!$name == '') {
      $this->name = Verifications::sanitizeString($name);
    }else{
      $err = true;
    }

    if(empty($err)){
      //return json_encode('maalin');
      //$dbRes = DatabaseHF::insertQueryLIID("INSERT INTO categories (user_id, name, icon, color, type) VALUES (":id, :userId, :name, :icon, :color, :type")", ['id'=>NULL, 'userId'=>$this->userId, 'name'=>$this->name, 'icon'=>$this->icon, 'color'=>$this->color, 'type'=>$this->expense]);
      $dbRes = DatabaseHF::insertQueryLIID([NULL, $this->userId, $this->name, $this->icon, $this->color, $this->expense]);
      return $dbRes;
    }else{
      return 'err';
    }
    //return json_encode('malin');
  }

}
