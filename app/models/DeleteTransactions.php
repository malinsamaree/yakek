<?php
class DeleteTransactions{
  public function deleteSelecteTransaction($transactionId){
    if(Verifications::validateInt($transactionId)){
      if(DatabaseHF::deleteQuery("DELETE FROM transactions WHERE id=:id", ['id'=>$transactionId])){
          echo 'success';
      }else{
          echo 'error';
      }
    }else{
      echo 'error';
    }
    //echo $transactionId;
  }
}
