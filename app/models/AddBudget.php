<?php
class AddBudget{

  private $err = false;
  private $errCode = '';

  private $userId;
  private $catId;
  private $budget;

  public function addNewBudget($userId, $catId, $budget, $month, $year){

    $budMonth = $year .'-'. $month .'-01';

    if(Verifications::validateInt($userId) != false){
        $this->userId = $userId;
    }else {
      $this->err = true;
    }

    if(Verifications::validateInt($catId) != false){
      $this->catId = $catId;
    }else {
      $this->err = true;
    }

    if($budget == 0 || Verifications::validateFloat($budget) != false){
      $this->budget = Verifications::roundFloat($budget);
    }else {
      $this->err = true;
    }

    //$this->budget = Verifications::roundFloat($budget);

    if (!$this->err) {
        $recordId = DatabaseHF::selectQuery("SELECT id FROM budget WHERE user_id=:userId AND cat_id=:catId AND bud_month=:budMonth", ['userId'=>$this->userId, 'catId'=>$this->catId, 'budMonth'=>$budMonth]);
        if(empty($recordId[0]['id'])){
          if(!DatabaseHF::insertQuery("INSERT INTO budget (user_id, cat_id, budget, bud_month) VALUES (:userId, :catId, :budget, :budMonth)", ['userId'=>$this->userId, 'catId'=>$this->catId, 'budget'=>$this->budget, 'budMonth'=>$budMonth])){
            $this->err = true;
          }
        }else{
          if (!DatabaseHF::updateQuery("UPDATE budget SET budget=:budget WHERE id=:id", ['budget'=>$this->budget, 'id'=>$recordId[0]['id']])) {
            $this->err = true;
          }
        }
    }

    return json_encode($this->err);
  }

}
