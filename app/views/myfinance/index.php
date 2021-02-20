<?php
  session_start();
  //var_dump($_SESSION);
  if(isset($_SESSION['user_id'])){
  $userId = $_SESSION['user_id'];
  $userEmail = Database::selectQuery("SELECT email FROM users WHERE id=:user_id", ['user_id'=>$userId]);

  // if (isset($_POST['value'])) {
  //   $value = $_POST['value'];
  //   $date = $_POST['date'];
  //   $description = $_POST['description'];
  //
  //   echo $date;
  // }
  //echo 'test';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/mir.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/heimfinanz.css">
    <link rel="stylesheet" href="css/header.css">

    <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicons/favicon-16x16.png">
    <link rel="manifest" href="images/favicons/site.webmanifest">
    <link rel="mask-icon" href="images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

  </head>
  <body>
    <div class="hf_mainContainer">
      <div class="hf_mainContainerInner">
        <div class="hf_heading">
          <div class="hf_headingInner">
            <div class="hf_headingMiddle"><img src="images/logo.png" alt=""></div>
            <div class="hf_headingRight">
              <span><?php echo $userEmail[0]['email']; ?></span>
              <i class="material-icons">settings</i>
              <!--  -->
            </div>
            <div class="hf_headingExtention">
              <div class="hf_headingExtentionInner">
                <div class="hf_headingExtentionDiv hf_headingExtentionBack">
                  <i class="material-icons">keyboard_backspace</i>
                </div>
                <div class="hf_headingExtentionDiv hf_headingExtentionLogoff">
                  <a href="user/logoff">Logoff</a>
                </div>
                <!-- <div class="hf_headingExtentionDiv hf_headingExtentionSeperator">
                  -
                </div> -->
                <div class="hf_headingExtentionDiv hf_headingExtentionChangePW">
                  <a href="user/changepw">Change password</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php //include 'app/views/templates/header.php' ?>
        <div class="hf_body">

          <div class="hf_bodyInner">
            <div class="hf_bodyInnerInner">
              <div class="hf_loaderWrapper">
                <div class="hf_loader">
                  <div class="hf_loaderInner">
                  </div>
                </div>
              </div>
              <div class="hf_content">

                <!-- heading -->
                <div class="hf_coreContentHeading">
                  <div class="hf_coreContentHeadingExpenses">
                    Expenses
                  </div>
                  <div class="hf_coreContentHeadingIncome">
                    Income
                  </div>
                </div>
                <!-- heading ends -->

                <!-- heading border -->
                <div class="hf_coreContentTopBorder"></div>
                <!-- heading border ends -->
                <form class="mainForm" method="post">
                <!-- amount input -->
                <div class="hf_amountInput">
                  <input type="number" step="0.01" name="amount" value="" placeholder=".00" autocomplete="off">
                </div>
                <!-- amount input ends -->

                <!-- note and date -->
                <div class="hf_noteAndDate">
                  <div class="hf_noteAndDateLeft">
                    <input type="text" name="note" value="" class="hf_note" placeholder="note:">
                  </div>
                  <div class="hf_noteAndDateRight">
                    <div class="hf_noteAndDateRighti">
                      <div class="hf_date">
                        <?php echo date("d.m.Y"); ?>
                      </div>
                      <div class="hf_dateArrowi">
                        <i class="material-icons">arrow_drop_down</i>
                      </div>
                    </div>
                    <div class="hf_dateArrow">
                      <!-- <i class="material-icons">arrow_drop_down</i> -->
                      <div class="hf_dateCalendar">
                        <!-- calander header -->
                        <div class="hf_calendarHeader">
                          <div class="hf_calendarHeaderLeftArr">
                            <i class="material-icons">keyboard_arrow_left</i>
                          </div>
                          <div class="hf_calendarHeaderMonthYear" data-month=<?php echo date('n') ?> data-year=<?php echo date('Y') ?>>

                          </div>
                          <div class="hf_calendarHeaderRightArr">
                            <i class="material-icons">keyboard_arrow_right</i>
                          </div>
                        </div>
                        <!-- calandar header ends -->
                        <div class="hf_calanderBody">
                          <div class="hf_calandarDatePref">
                            <div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div><div>S</div>
                          </div>
                          <div class="hf_calandarDates">

                          </div>
                        </div>
                        <div class="hf_calanderClose">
                          <i class="material-icons">expand_less</i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- note and date ends -->

                <?php
                $categories = DatabaseHF::selectQuery("SELECT * FROM categories WHERE user_id=:user_id AND is_hidden=:is_hidden", ['user_id'=>$userId, 'is_hidden'=>0]);
                ?>

                <!-- current category and submit -->
                <div class="hf_curCatAndSubmit">
                  <div class="hf_curCat" data-category-id = <?php echo $categories[0]['id'] ?>>
                    <div class="hf_curCatIcon">
                      <i class="material-icons"><?php echo $categories[0]['icon'] ?></i>
                    </div>
                    <div class="hf_curCatName">
                      <?php echo $categories[0]['name'] ?>
                    </div>
                  </div>
                  <div class="hr_submitDiv">
                    <div class="hr_submitDivInner" data-user-id = <?php echo $userId?>>
                      <i class="material-icons">check</i>
                    </div>

                  </div>
                </div>
                <input type="submit" class="mainFormSubmitBtn" name="" value="">
                <!-- current category and submit ends -->
              </form>
                <!-- categories -->
                <div class="hf_categories"></div>
                <!-- categories end -->

                <!-- new category -->
                <div class="newCategory">
                  <div class="newCategoryInner">
                    <form class="addNewCatForm" action="" method="post">
                      <div class="newCategoryHeading">
                        <div class="newCatCancelForm">
                          <div class="newCatCancelFormInner">
                            <i class="material-icons">keyboard_backspace</i>
                          </div>
                        </div>
                        <div class="newCatIcon" data-icon="add" data-color="#999999">
                          <i class="material-icons">add</i>
                        </div>
                        <div class="newCatInput">
                          <input type="text" name="newCatName" value="" placeholder="Name" class="newCatNameInput">
                        </div>
                        <div class="newCatsubmitForm">
                          <div class="newCatsubmitFormInner">
                            <i class="material-icons">check</i>
                          </div>
                          <input type="submit" class="addNewCatSubmitButton">
                        </div>
                      </div>
                      <div class="newCategoryContent">
                        <div class="newCategoryContentInner"></div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- new category ends -->

              </div>
              <!-- MAIN CONTENT ENDS================================================= -->
              <!-- EXTRAS BEGIN====================================================== -->
              <div class="hf_extra">
                <div class="hf_extra_inner">
                  <div class="hf_extraHeading">
                    <div class="hf_extraHeadingButtons">
                      <div class="hf_extraHeadingButtonsOverview">
                        Overview
                      </div>
                      <div class="hf_extraHeadingButtonsTransactions">
                        Transactions
                      </div>
                    </div>
                    <div class="hf_extraHeadingDate">
                      <!-- month selector ================================== -->
                      <div class="hf_catExtraMonthSelector">
                        <div class="hf_catExtraMonthSelectorInner">
                          <div class="hf_catExtraMonthName">
                            <?php echo date('M Y') ?>
                          </div>
                          <div class="hf_catExtraMonthArrow">
                            <i class="material-icons">arrow_drop_down</i>
                          </div>
                        </div>
                        <div class="hf_months">
                          <div class="hf_monthsInner">

                            <div class="hf_monthsYear">
                              <div class="hf_monthsYearLeftArrow">
                                <i class="material-icons">keyboard_arrow_left</i>
                              </div>
                              <div class="hf_monthsYearYear" data-this-year = <?php echo date('Y'); ?>>
                                <?php echo date('Y') ?>
                              </div>
                              <div class="hf_monthsYearRightArrow">
                                <i class="material-icons">keyboard_arrow_right</i>
                              </div>
                            </div>

                            <div class="hf_monthsMonths" data-this-month = <?php echo date('m'); ?>>
                              <div class="hf_monthsMonth hf_monthJan" data-month-no='01'>Jan</div>
                              <div class="hf_monthsMonth hf_monthFeb" data-month-no='02'>Feb</div>
                              <div class="hf_monthsMonth hf_monthMar" data-month-no='03'>Mar</div>
                              <div class="hf_monthsMonth hf_monthApr" data-month-no='04'>Apr</div>
                              <div class="hf_monthsMonth hf_monthMay" data-month-no='05'>May</div>
                              <div class="hf_monthsMonth hf_monthJun" data-month-no='06'>Jun</div>
                              <div class="hf_monthsMonth hf_monthJul" data-month-no='07'>Jul</div>
                              <div class="hf_monthsMonth hf_monthAug" data-month-no='08'>Aug</div>
                              <div class="hf_monthsMonth hf_monthSep" data-month-no='09'>Sep</div>
                              <div class="hf_monthsMonth hf_monthOct" data-month-no='10'>Oct</div>
                              <div class="hf_monthsMonth hf_monthNov" data-month-no='11'>Nov</div>
                              <div class="hf_monthsMonth hf_monthDec" data-month-no='12'>Dec</div>
                            </div>
                            <div class="hf_monthsClose">
                              <i class="material-icons">expand_less</i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- ------------------------------------------------------------- -->
                    </div>
                  </div>
                  <!-- summary -->
                  <div class="hf_monthlySummary">
                    <div class="hf_monthlySummaryInner">
                      <div class="hf_monthlySummaryIncome">
                        <div class="hf_monthlySummaryHeader">Income</div>
                        <div class="hf_monthlySummaryBody hf_monthlySummaryBodyIncome"></div>
                      </div>
                      <div class="hf_monthlySummaryExpenses">
                        <div class="hf_monthlySummaryHeader">Expenses</div>
                        <div class="hf_monthlySummaryBody hf_monthlySummaryBodyExpenses"></div>
                      </div>
                      <div class="hf_monthlySummaryBalance">
                        <div class="hf_monthlySummaryHeader">Balance</div>
                        <div class="hf_monthlySummaryBody hf_monthlySummaryBodyBalance"></div>
                      </div>
                    </div>
                  </div>
                  <!-- summary ends -->
                  <!-- monthly summary extra begins -->
                  <div class="hf_monthlySummaryExtra">
                    <div class="hf_monthlySummaryExtraInner">
                      <!-- <div class="hf_ms_heading">
                        Monthly
                      </div> -->
                      <div class="hf_ms_body">
                        <!-- expenses -->
                        <div class="hf_ms_expenses">
                          <div class="hf_ms_expensesBrief">
                            <div class="hf_ms_expenseSymbol">
                              <i class="material-icons">trending_down</i>
                            </div>
                            <div class="hf_ms_expensePercentage"></div>
                          </div>
                          <div class="hf_ms_expensesDetails">
                            <div class="hf_ms_expensesDetailsActual">
                              <div class="hf_ms_expensesDetailsActualDetail">
                                Actual: <span></span>
                              </div>
                              <div class="hf_ms_expensesDetailsActualGraph"></div>
                            </div>
                            <div class="hf_ms_expensesDetailsBudget">
                              <div class="hf_ms_expensesDetailsBudgetDetail">
                                Budgeted: <span></span>
                              </div>
                              <div class="hf_ms_expensesDetailsBudgetGraph"></div>
                            </div>
                          </div>
                        </div>
                        <!-- income -->
                        <div class="hf_ms_income">
                          <div class="hf_ms_incomeBrief">
                            <div class="hf_ms_incomeSymbol">
                              <i class="material-icons">trending_up</i>
                            </div>
                            <div class="hf_ms_incomePercentage"></div>
                          </div>
                          <div class="hf_ms_incomeDetails">
                            <div class="hf_ms_incomeDetailsActual">
                              <div class="hf_ms_incomeDetailsActualDetail">
                                Actual: <span></span>
                              </div>
                              <div class="hf_ms_incomeDetailsActualGraph"></div>
                            </div>
                            <div class="hf_ms_incomeDetailsBudget">
                              <div class="hf_ms_incomeDetailsBudgetDetail">
                                Budgeted: <span></span>
                              </div>
                              <div class="hf_ms_incomeDetailsBudgetGraph"></div>
                            </div>
                          </div>
                        </div>
                        <!-- ------------ -->
                      </div>
                    </div>
                  </div>
                  <!-- monthly summaru extra ends -->
                  <!-- category extra----------------------------------------------- -->
                  <div class="hf_catExtra">
                    <div class="hf_categoryCircle">
                      0%
                    </div>
                    <div class="hf_categoryOverview" data-user-id=<?php echo $userId?> data-category-id = <?php echo $categories[0]['id'] ?>>
                      <!-- category icon and name------------------------ -->
                      <div class="hf_categoryOverviewIconAndName">
                        <div class="hf_categoryOverviewIcon" style="background:<?php echo $categories[0]['color'] ?>">
                          <i class="material-icons"><?php echo $categories[0]['icon'] ?></i>
                        </div>
                        <div class="hf_categoryOverviewName">
                          <?php echo $categories[0]['name'] ?>
                        </div>
                      </div>
                      <!-- ---------------- -->
                      <!-- category total------------------------------------- -->
                      <div class="hf_catTotal">
                        <div class="hf_catTotalType"></div>
                        <div class="hf_catTotalAmount"></div>
                      </div>
                      <!-- --------------------------------------------------- -->
                      <!-- budget--------------------------------------------- -->
                      <div class="hf_catBudget">
                        <div class="hf_catBudgetIcon">
                          <i class="material-icons">monetization_on</i>
                        </div>
                        <div class="hf_catBudgetContent"></div>
                        <form class="hf_catBudgetContentForm" action="" method="post">
                        <div class="hf_catSetBudget">
                            <div class="hf_catSetBudgetInput">
                              <input type="number" class="hf_catSetBudgetInputNumber" name="hf_catSetBudgetInputNumber" step="0.00" min="0" placeholder=".00">
                            </div>

                              <div class="hf_catSetBudgetBtnClear">
                                  <i class="material-icons">undo</i>
                              </div>
                              <div class="hf_catSetBudgetBtnAdd">
                                  <i class="material-icons">check_circle</i>
                              </div>
                              <input type="submit" class="hf_catSetBudgetBtnSubmit" name="hf_catSetBudgetBtnSubmit" value="->">

                        </div>
                        </form>
                      </div>
                      <!-- --------------------------------------------------- -->
                    </div>
                  </div>
                  <!-- --------------------------------------------------------- -->

                  <!-- transactions div -->
                  <div class="hf_transactionsExtra">
                    <div class="hf_transactionsExtraInner">
                      <div class="hf_transactionHistory">

                      </div>
                    </div>
                  </div>
                  <!-- transactions div ends -->
                </div>
              </div>
              <!-- EXTRAS ENDS======================================================= -->
            </div>

          </div>
        </div>
        <!-- <div class="footer">
          asd
        </div> -->
        <!-- ads====================================================================== -->
        <div class="">
        </div>
        <!-- ads ends================================================================= -->
        <!-- legal texts============================================================== -->
        <div class="legalTexts">
          <div class="legalTextsInner">
            <div class="legalTextsLinks">
                <a href="texts/imprint">imprint</a>
                <a href="texts/tac">terms & conditions</a>
                <a href="texts/pp">privacy policy</a>

            </div>
          </div>
        </div>
        <!-- legal texts end========================================================== -->
      </div>
   </div>
  </body>
</html>
<?php
  }else{
    header('location:user/login');
  }
?>
