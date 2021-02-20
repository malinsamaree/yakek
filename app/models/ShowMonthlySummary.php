<?php
class ShowMonthlySummary{

  public function showThisMonthSummary($userId, $month, $year){
    $thisDate = $year . '-' . $month . '-01';

    // $lowerDate = $year . '-' . $month . '-01';
    // $higherDateTime = new DateTime($lowerDate);
    // $higherDate = $higherDateTime->format('Y-m-t');

    //expense total budget
    $allExpenseCats = DatabaseHF::selectQuery("SELECT id FROM categories WHERE user_id=:userId AND type=:type", ['userId'=>$userId, 'type'=>1]);

    $thisTotal = 0;
    $prevTotal = 0;
    $nextTotal = 0;

    foreach ($allExpenseCats as $allCatRow) {
      if($firstQuery = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE cat_id=:catId AND bud_month=:budMonth", ['catId'=>$allCatRow['id'], 'budMonth'=>$thisDate])){
        foreach ($firstQuery as $curRow) {
          $thisTotal += $curRow['budget'];
        }
      }elseif ($prevQuery = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE cat_id=:catId AND bud_month<:budMonth AND special=:special  ORDER BY bud_month DESC LIMIT 1", ['catId'=>$allCatRow['id'], 'budMonth'=>$thisDate, 'special'=>0])) {
        foreach ($prevQuery as $prevRow) {
          $prevTotal += $prevRow['budget'];
        }
      }elseif ($nextQuery = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE cat_id=:catId AND bud_month>:budMonth AND special=:special  ORDER BY bud_month ASC LIMIT 1", ['catId'=>$allCatRow['id'], 'budMonth'=>$thisDate, 'special'=>0])) {
        foreach ($nextQuery as $nextRow) {
          $nextTotal += $nextRow['budget'];
        }
      }
    }

    $totalExpenseBudget = $thisTotal+$prevTotal+$nextTotal;

    //incomeTotalBudget
    $allIncomeCats = DatabaseHF::selectQuery("SELECT id FROM categories WHERE user_id=:userId AND type=:type", ['userId'=>$userId, 'type'=>0]);

    $thisTotalIncome = 0;
    $prevTotalIncome = 0;
    $nextTotalIncome = 0;

    foreach ($allIncomeCats as $allCatRow) {
      if($firstQuery = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE cat_id=:catId AND bud_month=:budMonth", ['catId'=>$allCatRow['id'], 'budMonth'=>$thisDate])){
        foreach ($firstQuery as $curRow) {
          $thisTotalIncome += $curRow['budget'];
        }
      }elseif ($prevQuery = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE cat_id=:catId AND bud_month<:budMonth AND special=:special  ORDER BY bud_month DESC LIMIT 1", ['catId'=>$allCatRow['id'], 'budMonth'=>$thisDate, 'special'=>0])) {
        foreach ($prevQuery as $prevRow) {
          $prevTotalIncome += $prevRow['budget'];
        }
      }elseif ($nextQuery = DatabaseHF::selectQuery("SELECT budget FROM budget WHERE cat_id=:catId AND bud_month>:budMonth AND special=:special  ORDER BY bud_month ASC LIMIT 1", ['catId'=>$allCatRow['id'], 'budMonth'=>$thisDate, 'special'=>0])) {
        foreach ($nextQuery as $nextRow) {
          $nextTotalIncome += $nextRow['budget'];
        }
      }
    }

    $totalIncomeBudget = $thisTotalIncome + $prevTotalIncome + $nextTotalIncome;

    $returnArr = ['expense'=>number_format($totalExpenseBudget, 2), 'income'=>number_format($totalIncomeBudget, 2)];

    return json_encode($returnArr);
  }

}
