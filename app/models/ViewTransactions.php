<?php
class viewTransactions{

  private $returnString = '';

  public function viewEachTransaction($userId, $month, $year){
    $lowerDate = $year . '-' . $month . '-01';
    $higherDateTime = new DateTime($lowerDate);
    $higherDate = $higherDateTime->format('Y-m-t');

    $transactions = DatabaseHF::selectQuery("SELECT id, idate, amount, note, cat_id, time_entered FROM transactions WHERE user_id=:userId AND (idate BETWEEN :lowerDate AND :higherDate) ORDER BY idate DESC, time_entered DESC ", ['userId'=>$userId, 'lowerDate'=>$lowerDate, 'higherDate'=>$higherDate]);
    foreach ($transactions as $row) {
      $getCategory = DatabaseHF::selectQuery("SELECT name, icon, color, type FROM categories WHERE id=:id", ['id'=>$row['cat_id']]);
      $this->returnString .= '<div class="tr_row">';
        $this->returnString .= '<div class="tr_data">';
          if ($getCategory[0]['type'] == 1) {
            $this->returnString .= '<div class="tr_trend" style="color:red"><i class="material-icons">trending_down</i></div>';
          }else{
            $this->returnString .= '<div class="tr_trend" style="color:green"><i class="material-icons">trending_up</i></div>';
          }


          $this->returnString .= '<div class="tr_catlogo" style="background:'.$getCategory[0]['color'].'"><i class="material-icons">'.$getCategory[0]['icon'].'</i></div>';
          $this->returnString .= '<div class="tr_catname">'.$getCategory[0]['name'].'</div>';
          $this->returnString .= '<div class="tr_date">' . $row['idate'] . '</div>';
          $this->returnString .= '<div class="tr_amount">' . number_format($row['amount'], 2) . '</div>';
          $this->returnString .= '<div class="tr_delete" data-transaction-id='.$row['id'].'><i class="material-icons">delete_forever</i></div>';
        $this->returnString .= '</div>';
        $this->returnString .= '<div class="tr_row_note">' . $row['note'] . '</div>';
      $this->returnString .= '</div>';
      //$row['idate'];
    }

    return $this->returnString;
  }

}
