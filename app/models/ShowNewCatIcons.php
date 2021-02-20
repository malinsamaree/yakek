<?php
class ShowNewCatIcons{

  public function showAllNewCatIcons($userId, $expense){
    $expenseType;
    if($expense == 'true'){
      $expenseType = 1;
    }else{
      $expenseType = 0;
    }

    $returnHtmlDivs = '';
    $icons = DatabaseHF::selectQuery("SELECT * FROM icons");

    foreach ($icons as $row) {
      $returnHtmlDivs .= '<div class="indNewCatIcon">';
        $returnHtmlDivs .= '<div class="indNewCatIconInner" style="background:'.$row['color'].'"  data-icon="'.$row['icon'].'" data-color="'.$row['color'].'">';
          $returnHtmlDivs .= '<i class="material-icons">'.$row['icon'].'</i>';
        $returnHtmlDivs .= '</div>';
      $returnHtmlDivs .= '</div>';
    }

    return $returnHtmlDivs;
    //return $icons[0]['icon'];
  }

}
