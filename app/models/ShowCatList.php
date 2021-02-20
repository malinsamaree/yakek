<?php
class ShowCatList{

  private $returnHtml = '';

  public function showCategoryList($userId, $expense){
    $expenseType;
    if($expense == 'false'){
      $expenseType = 0;
    }elseif ($expense == 'true') {
      $expenseType = 1;
    }

    $catRes = DatabaseHF::selectQuery("SELECT * FROM categories WHERE user_id=:userId AND type=:type AND is_hidden=:isHidden", ['userId'=>$userId, 'type'=>$expenseType, 'isHidden'=>0]);
    foreach ($catRes as $row) {
      $catId = $row['id'];
      $catName = str_replace(" ", "&nbsp;", $row['name']);
      $catIcon = $row['icon'];
      $catColor = $row['color'];

      $this->returnHtml .= '<div class="mainCatIndividual" data-user-id='.$userId.' data-category-id='.$catId.' data-category-name='.$catName.' data-category-icon = '.$catIcon.' data-category-color = '.$catColor.'>';
        $this->returnHtml .= '<div class="mainCatIndividualTop" style="background:'.$catColor.'">';
          $this->returnHtml .= '<i class="material-icons">'.$catIcon.'</i>';
        $this->returnHtml .= '</div>';
        $this->returnHtml .= '<div class="mainCatIndividualBottom">';
        if (strlen($row['name'])>9) {
            $this->returnHtml .= substr($row['name'], 0, 8) . '.';
        }else{
            $this->returnHtml .= $row['name'];
        }
        $this->returnHtml .= '</div>';
      $this->returnHtml .= '</div>';
    }

      $this->returnHtml .= '<div class="mainCatIndividual" data-category-id="addNewCategory">';
        $this->returnHtml .= '<div class="mainCatIndividualTop" style="background:#999999; border:#333333 solid 1px;">';
          $this->returnHtml .= '<i class="material-icons">add</i>';
        $this->returnHtml .= '</div>';
        $this->returnHtml .= '<div class="mainCatIndividualBottom">Add new</div>';
      $this->returnHtml .= '</div>';

    //return $catRes[0]['icon'];
    $arr = ['htmlcontent'=>$this->returnHtml, 'catId'=>$catRes[0]['id']];

    return json_encode($arr);
  }

}
