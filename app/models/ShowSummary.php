<?php
class ShowSummary{

  public function showTheSummary($userId, $month, $year){

    $lowerDate = $year . '-' . $month . '-01';
    $higherDateTime = new DateTime($lowerDate);
    $higherDate = $higherDateTime->format('Y-m-t');

    $expenses = DatabaseHF::selectQuery("SELECT SUM(amount) AS TotalAmount FROM transactions WHERE amount < 0 AND user_id=:user_id AND (idate BETWEEN :lowerDate AND :higherDate)", ['user_id'=>$userId, 'lowerDate'=>$lowerDate, 'higherDate'=>$higherDate]);
    $income = DatabaseHF::selectQuery("SELECT SUM(amount) AS TotalAmount FROM transactions WHERE amount > 0 AND user_id=:user_id AND (idate BETWEEN :lowerDate AND :higherDate)", ['user_id'=>$userId, 'lowerDate'=>$lowerDate, 'higherDate'=>$higherDate]);

    $balance = floatval($income[0]['TotalAmount']) + floatval($expenses[0]['TotalAmount']);

    $expensesStr = number_format($expenses[0]['TotalAmount'], 2);
    $incomeStr = number_format($income[0]['TotalAmount'], 2);
    $balanceStr = number_format($balance, 2);

    $arr = ['income'=>$incomeStr, 'expenses'=>$expensesStr, 'balance'=>$balanceStr];



    return json_encode($arr);
  }

}
