<?php
class ViewBudget{

  private $budget;

  public function checkBudget($userId, $catId, $month, $year){

    $thisDate = $year . '-' . $month . '-01';

    $budgetCurr = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE user_id = :userId AND cat_id = :catId AND bud_month = :budMonth", ['userId'=>$userId, 'catId'=>$catId, 'budMonth'=>$thisDate] );
    $budgetPast = DatabaseHF::selectQuery("SELECT budget, bud_month FROM budget WHERE user_id = :userId AND cat_id = :catId AND bud_month < :budMonth AND special=:special ORDER BY bud_month DESC LIMIT 1", ['userId'=>$userId, 'catId'=>$catId, 'budMonth'=>$thisDate, 'special'=>0] );
    $budgetFuture = DatabaseHF::selectQuery("SELECT budget, bud_month FROM budget WHERE user_id = :userId AND cat_id = :catId AND bud_month > :budMonth AND special=:special ORDER BY bud_month ASC LIMIT 1", ['userId'=>$userId, 'catId'=>$catId, 'budMonth'=>$thisDate, 'special'=>0] );

    if (!count($budgetCurr) == 0) {
      $this->budget = $budgetCurr[0]['budget'];
    }elseif (!count($budgetPast) == 0) {
      $this->budget = $budgetPast[0]['budget'];
    }elseif (!count($budgetFuture) == 0) {
      $this->budget = $budgetFuture[0]['budget'];
    }else{
      $this->budget = "Set budget";
    }
     // if(count($budgetCurr) == 0){
     //   // if () {
     //   //   // code...
     //   // }
     //   //$budgetReturn = 'Set budget';
     // }

     // else{
     //  $budgetReturn = $budget[0]['budget'];
     //  }

    //$arr = $budgetReturn;
    //return json_encode($budgetFuture);
    return json_encode($this->budget);
  }

}
