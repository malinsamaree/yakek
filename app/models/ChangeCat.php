<?php
class ChangeCat{
  public function changeCategory($userId, $catId, $month, $year){

    $lowerDate = $year . '-' . $month . '-01';
    $higherDateTime = new DateTime($lowerDate);
    $higherDate = $higherDateTime->format('Y-m-t');

    $catTypeStr = '';
    $catType = DatabaseHF::selectQuery("SELECT name, icon, color, type FROM categories WHERE id=:id", ['id'=>$catId]);

    $totalAmount = DatabaseHF::selectQuery("SELECT SUM(amount) AS TotalAmount FROM transactions WHERE user_id=:user_id AND cat_id=:cat_id AND (idate BETWEEN :lowerDate AND :higherDate)", ['user_id'=>$userId, 'cat_id'=>$catId, 'lowerDate'=>$lowerDate, 'higherDate'=>$higherDate]);
    $totalAmountValue = $totalAmount[0]['TotalAmount'];
    if($totalAmountValue == NULL){
      $totalAmountValue = 0;
    }
    $totalAmountValue = number_format($totalAmountValue, 2, '.', '');
    // if($totalAmount == null){
    //   $totalAmount = 0;
    // }else{
    //   $totalAmount = number_format($totalAmount, 2);
    // }

    $arr = ['totalAmount' => $totalAmountValue, 'catType' => $catType[0]['type'], 'catIcon'=>$catType[0]['icon'], 'catName'=>$catType[0]['name'], 'catColor'=>$catType[0]['color']];
    return $arr;
  }
}
