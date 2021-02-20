<?php
class AddTransaction{

  private $err = false;
  private $errCode = "";

  private $amount;
  private $date;
  private $expense;
  private $note;
  private $userId;
  private $catId;

  public function addNewTransaction($userId, $catId, $amount, $date, $note, $expense){

    // amount
    if (empty(Verifications::validateFloat($amount))) {
      $this->err = true;
    }else{
      //$amountVal = Verifications::roundFloat($amount);
      if($expense == 'true'){
        $amountVal = -(Verifications::roundFloat($amount));
      }elseif($expense == 'false'){
        $amountVal = Verifications::roundFloat($amount);
      }
      $this->amount = $amountVal;
    }

    // date
    $dateParts = explode(".", $date);
    $dateDate = $dateParts[0];
    $dateMonth = $dateParts[1];
    $dateYear = $dateParts[2];
    $isDateValid = Verifications::validateDate($dateDate, $dateMonth, $dateYear);
    if (empty($isDateValid)) {
      $this->err = true;
    }else{
      $this->date = $dateYear . '-' . $dateMonth . '-' . $dateDate;
    }

    // note
    $this->note = Verifications::sanitizeString($note);

    //user id
    if(empty(Verifications::validateInt($userId))){
      $this->err = true;
    }else{
      $this->userId = Verifications::validateInt($userId);
    }

    //category id
    if(empty(Verifications::validateInt($catId))){
      $this->err = true;
    }else{
      $this->catId = Verifications::validateInt($catId);
    }

    if (!$this->err) {
      if(DatabaseHF::insertQuery("INSERT INTO transactions (user_id, idate, amount, note, cat_id) VALUES (:user_id, :idate, :amount, :note, :cat_id)", ['user_id'=>$this->userId, 'idate'=>$this->date, 'amount'=>$this->amount, 'note'=>$this->note, 'cat_id'=>$this->catId])){

      }else{
        $this->err = true;
      }
    }

    return $this->err;

  }

}
