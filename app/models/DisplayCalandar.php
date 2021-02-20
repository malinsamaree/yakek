<?php
class DisplayCalandar{

  public function displayTheCalandar($month, $year, $but){

    $thisMonth;
    $thisYear;

    if($but == 0){
      $thisMonth = $month;
      $thisYear = $year;
    }elseif ($but == 1) {
      if($month == 1){
        $thisMonth = 12;
        $thisYear = $year - 1;
      }else{
        $thisMonth = $month - 1;
        $thisYear = $year;
      }
    }elseif($but == 2){
      if($month == 12){
        $thisMonth = 1;
        $thisYear = $year + 1;
      }else{
        $thisMonth = $month + 1;
        $thisYear = $year;
      }
    }

    $d = new DateTime($thisYear . '-' . $thisMonth . '-01' );
    $firstDay = $d->format('N');
    $numDays = $d->format('t');
    $monthText = $d->format('M');
    $monthNumber = $d->format('m');

    $calandarText = '';
    for ($i=1; $i < $firstDay; $i++) {
      $calandarText .= '<div class="disabledDays"></div>';
    }
    for ($i=0; $i < $numDays ; $i++) {
      $calandarText .= '<div class="enabledDays">'. ($i+1) . '</div>';
    }

    $arr = ['month'=>$thisMonth, 'year'=>$thisYear, 'monthNumber'=>$monthNumber, 'monthName'=>$monthText, 'htmlDivs'=>$calandarText];
    return json_encode($arr);
    //return $monthText;
  }


}
