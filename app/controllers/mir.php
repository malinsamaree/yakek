<?php
class Mir extends Controller{

  public function index(){
    $this->view('myfinance/index');
  }

  public function addTransaction($userId, $catId, $amount, $date, $note, $expense){
    //return 'Melanie';
    //require_once '../app/models/AddTransactions.php';
    // $addTransaction = $this->model('AddTransaction');
    $addTransaction = new AddTransaction;
    $addedTransaction = $addTransaction->addNewTransaction($userId, $catId, $amount, $date, $note, $expense);
    return $addedTransaction;
  }

  public function changeCategory($userId, $catId, $month, $year){
    $changeCat = new ChangeCat;
    $changedCat = $changeCat->changeCategory($userId, $catId, $month, $year);
    return $changedCat;
  }

  public function viewBudget($userId, $catId, $month, $year){
    $viewBudget = new ViewBudget;
    $viewedBudget = $viewBudget->checkBudget($userId, $catId, $month, $year);
    return $viewedBudget;
  }

  public function addBudget($userId, $catId, $budget, $month, $year){
    $addBudget = new AddBudget;
    $addedBudget = $addBudget->addNewBudget($userId, $catId, $budget, $month, $year);
    return $addedBudget;
  }

  public function calcPerCat($userId, $catId, $month, $year){
    $changeCat = new ChangeCat;
    $changedCat = $changeCat->changeCategory($userId, $catId, $month, $year);
    $totalAmount = $changedCat['totalAmount'];
    $totalPositiveAmount;
    if ($totalAmount < 0) {
      $totalPositiveAmount = floatval($totalAmount * (-1));
    }else{
      $totalPositiveAmount = floatval($totalAmount);
    }
    $viewBudget = new ViewBudget;
    $viewedBudget = $viewBudget->checkBudget($userId, $catId, $month, $year);
    $viewedBudgetJsonDecode = json_decode($viewedBudget);
    $viewPositiveBudget;
    $percent;
    if($viewedBudgetJsonDecode == 'Set budget'){
      $viewPositiveBudget = 0;
      $percent = 0;
    }else{
      $viewPositiveBudget =  $viewedBudgetJsonDecode;
      $percent = round($totalPositiveAmount/$viewPositiveBudget*100, 2);
    }

    $arr = ['percentage'=>$percent, 'catType'=> $changedCat['catType']];

    return json_encode($arr);
  }

  public function viewTransactions($userId, $month, $year){
    $viewEachTransaction = new ViewTransactions;
    $viewedEachTransaction = $viewEachTransaction->viewEachTransaction($userId, $month, $year);
    return $viewedEachTransaction;
  }

  public function deleteTransactions($transactionId){
    $deleteTransactions = new DeleteTransactions;
    $deletedTransactions = $deleteTransactions->deleteSelecteTransaction($transactionId);
    return $deletedTransactions;
  }

  public function showSummary($userId, $month, $year){
    $showSummary = new ShowSummary;
    $showedSummary = $showSummary->showTheSummary($userId, $month, $year);
    return $showedSummary;
  }

  public function showCatList($userId, $expense){
    $showCatList = new ShowCatList;
    $showedCatList = $showCatList->showCategoryList($userId, $expense);
    return $showedCatList;
  }

  public function showNewCatIcons($userId, $expense){
    $showNewCatIcons = new ShowNewCatIcons;
    $showedNewCatIcons = $showNewCatIcons->showAllNewCatIcons($userId, $expense);
    return $showedNewCatIcons;
  }

  public function addNewCat($userId, $expense, $icon, $color, $name){
    $addNewCat = new AddNewCat;
    $addedNewCat = $addNewCat->addTheNewCat($userId, $expense, $icon, $color, $name);
    return $addedNewCat;
  }

  public function showMonthlySummary($userId, $month, $year){
    $showMonthlySummary  = new ShowMonthlySummary;
    $showedMonthlySummary = $showMonthlySummary->showThisMonthSummary($userId, $month, $year);
    return $showedMonthlySummary;
  }

  public function displayCalandar($month, $year, $but){
    $displayCalandar  = new DisplayCalandar;
    $displayedCalandar = $displayCalandar->displayTheCalandar($month, $year, $but);

    return $displayedCalandar;
  }

}
