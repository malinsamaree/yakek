$(document).ready(function(){
  // * VARIABLES * VARIABLES * VARIABLES * VARIABLES * VARIABLES * VARIABLES * VARIABLES

  var expense = true;
  var userId = $('.hf_categoryOverview').data('user-id');
  var defaultCatId = $('.hf_categoryOverview').data('category-id');
  var thisYear = parseInt($('.hf_monthsYearYear').text().trim());
  var thisMonth = $('.hf_monthsMonths').data('this-month');

  // * VARIABLES * VARIABLES * VARIABLES * VARIABLES * VARIABLES * VARIABLES * VARIABLES

  //SELECT THE FIRST CATEGORY===================================================
  //setSelectedCategory(userId, defaultCatId, thisMonth, thisYear)
  //SELECT THE FIRST CATEGORY ENDS==============================================

  //BUDGET DISPLAY =============================================================
  displayBudget(userId, defaultCatId, thisMonth, thisYear);
  //BUDGET DISPLAY ENDS ========================================================

  //PERCENTAGE DISPLAY - CATEGORY WISE =========================================
  //calculatePercentageCat(userId, defaultCatId, thisMonth, thisYear);
  //PERCENTAGE DISPLAY - CATEGORY WISE ENDS ====================================

  // SHOW TRANSACTIONS =========================================================
  showTransactions(userId, thisMonth, thisYear);
  // SHOW TRANSACTIONS END =====================================================

  //SHOW SUMMARY ===============================================================
  showMonthlySummary(userId, thisMonth, thisYear);
  //SHOW SUMMARY ENDS ==========================================================

  //SHOW CATEGORY LIST =========================================================
  showCategoryList(userId, expense);
  //SHOW CATEGORY LIST OVER ====================================================

  //SHOW MONTHLY BRIEF =========================================================
  showMonthlyBrief();
  //SHOW MONTHLY BRIEF OVER ====================================================

  // DISPLAY CALANDAR ==========================================================
  displayCalandar();
  // DISPLAY CALANDAR ENDS =====================================================

  //HIDE CALANDARS =============================================================
  // $('html').on('click', function(e){
  //   if(!$(e.target).hasClass('hf_dateArrow') ){
  //     $('.hf_dateCalendar').hide();
  //   }
  //   //alert('asd');
  // });
  //HIDE CALANDARS ENDS ========================================================

  $('.hf_amountInput input').focus();
  // ON TRANSACTION FORM SUBMIT=================================================
  $('.hr_submitDiv').on('click', function(){
    $('.mainForm').submit();
  });

  $(document).on('submit', '.mainForm', function(e){
    e.preventDefault();
    var err = false;
    var amount = $('.hf_amountInput input').val();
    //amount
    if(!amount.trim()){
        err = true;
        $('.hf_amountInput input').css({'border-bottom-color':'red'});
    }else{
      err = false
    }
    // note
    var note = $('.hf_note').val();
    // date
    var datei = $('.hf_date').text().trim();
    // category id
    var catId = defaultCatId;
    //var catId = $('.hf_curCat').data('category-id');
    //user id
    var userId = $('.hr_submitDivInner').data('user-id');

    if (!err) {
      $.ajax({
        url:'app/support/addTransaction.php',
        data:{'userId': userId, 'catId':catId, 'amount':amount, 'date':datei, 'note':note, 'expense':expense},
        type: 'post',
        beforeSend: function(){
          $('.hf_loaderWrapper').fadeIn('fast');
        },
        complete: function(){
          $('.hf_loaderWrapper').fadeOut('fast');
        },
        success: function(data){
          thisMonth = $('.hf_calendarHeaderMonthYear').data('month');
          thisYear = $('.hf_calendarHeaderMonthYear').data('year');
          var thisMonthArray = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
          $('.hf_catExtraMonthName').html(thisMonthArray[parseInt(thisMonth)-1] + ' ' + thisYear);
          $('.hf_monthsYearYear').html(thisYear);
          setSelectedCategory(userId, defaultCatId, thisMonth, thisYear);
          displayBudget(userId, defaultCatId, thisMonth, thisYear);
          calculatePercentageCat(userId, defaultCatId, thisMonth, thisYear);
          showTransactions(userId, thisMonth, thisYear);
          showMonthlySummary(userId, thisMonth, thisYear);
          showMonthlyBrief();
          clickTransactionButton();
          $('.hf_amountInput input').val('');
        }
      });
    }

  });
  // ON TRANSACTION FORM SUBMIT ENDS============================================

  // ONFOCUS ELEMENTS===========================================================
  $('.hf_amountInput input').on('focus', function(){
    $(this).css({'background':'#ffffff', 'color':'#666666', 'border-bottom-color':'#999999'});
  });
  // ONFOCUS ELEMENTS ENDS======================================================

  // SELECT CATEGORY============================================================
  $(document).on('click', '.mainCatIndividual', function(){

    if($(this).data('category-id') == 'addNewCategory'){
      showNewCatIcons();
    }else{
      clickOverviewButton();
      hideSetBudgetForm();
      // $('.hf_curCatName').text($(this).data('category-name'));
      // $('.hf_curCatIcon .material-icons').text($(this).data('category-icon'));
      var catId = $(this).data('category-id');
      $('.hf_curCat').data('category-id', catId);
      defaultCatId = $(this).data('category-id');
      $userIdd = $(this).data('user-id');
      setSelectedCategory($userIdd, defaultCatId, thisMonth, thisYear);
      displayBudget($userIdd, defaultCatId, thisMonth, thisYear);
    }
  });
  //SELECT CATEGORY ENDS========================================================

  //ADD NEW CATEGORY CANCEL ====================================================
  $('.newCatCancelFormInner').on('click', function(){
    hideAddNewCategory();
  });
  //ADD NEW CATEGORY CANCEL ENDS================================================

  // CLICK ON NEW CAT ICON =====================================================
  $(document).on('click', '.indNewCatIconInner', function(){
    var icon = $(this).data('icon');
    var color = $(this).data('color');
    $('.newCatIcon .material-icons').text(icon);
    $('.newCatIcon').css({'background':color, 'border-color':'#333333', 'color':'#000000'});
    $('.newCatIcon').data('icon', icon);
    $('.newCatIcon').data('color', color);
    //alert(color);
  });
  // CLICK ON NEW CAT ICON ENDS ================================================

  //ADD NEW CAT SUBMIT =========================================================
  $(document).on('click', '.newCatsubmitFormInner', function(){
    $('.addNewCatForm').submit();
  });

  $(document).on('submit', '.addNewCatForm', function(e){
    e.preventDefault();
    var icon = $('.newCatIcon').data('icon');
    var color = $('.newCatIcon').data('color');
    var namei = $('.newCatNameInput').val();
    var err = false;
    if (icon == 'add') {
      err = true;
      $('.newCatIcon').css({'color':'red', 'border-color':'red', 'background':'white'});
    }
    if ($('.newCatNameInput').val() == '') {
      err = true;
      $('.newCatNameInput').css({'border-color':'red'});
      $('.newCatNameInput').focus();
    }
    if (!err) {
      $.ajax({
        //dataType: 'json',
        url: 'app/support/addNewCat.php',
        data:{'userId': userId, 'expense': expense, 'icon':icon, 'color':color, 'name':namei},
        type: 'post',
        beforeSend: function(){
          $('.hf_loaderWrapper').fadeIn('fast');
        },
        complete: function(){
          $('.hf_loaderWrapper').fadeOut('fast');
        },
        success: function(data){
          if (data != 'err') {
            showCategoryList(userId, expense, 0);
            defaultCatId = data;
            //console.log(defaultCatId);
            //setSelectedCategory(userId, defaultCatId, thisMonth, thisYear);
            // console.log(defaultCatId);
            //displayBudget(userId, defaultCatId, thisMonth, thisYear);
            hideAddNewCategory();
            clickOverviewButton();
            hideSetBudgetForm();
            // console.log(defaultCatId);
          }else{
            $('.newCatIcon').css({'color':'red', 'border-color':'red', 'background':'white'});
            $('.newCatNameInput').css({'border-color':'red', 'color':'red'});
          }
        }
      });
    }
    //console.log(err);
  });

  $(document).on('keyup', '.newCatNameInput', function(){
    $('.newCatNameInput').css({'border-color':'#999999', 'color':'#000000'});
  })
  //ADD NEW CAT SUBMIT ENDS=====================================================

  //TOGGLE SET BUDGET ==========================================================
  $('.hf_catBudgetContent').on('click', function(){
    $(this).fadeOut('fast', function(){
      // console.log(defaultCatId);
      $('.hf_catSetBudget').css({'display':'flex'});
      $('input.hf_catSetBudgetInputNumber').focus();
    });
    //$('input.hf_catSetBudgetInputNumber').focus();
  });
  $('.hf_catSetBudgetBtnClear').on('click', function(){
    hideSetBudgetForm();
  });
  //TOGGLE SET BUDGET ENDS =====================================================

  //SET BUDGET =================================================================
  $('.hf_catSetBudgetBtnAdd').on('click', function(){
      $('.hf_catBudgetContentForm').submit();
      // console.log(defaultCatId);
  });
  $('.hf_catBudgetContentForm').on('submit', function(e){
    e.preventDefault();
    var budgetVal = $('.hf_catSetBudgetInputNumber').val();
    if(!budgetVal){
      $('.hf_catSetBudgetInputNumber').css({'border-bottom-color':'red'});
      $('.hf_catSetBudgetInputNumber').attr('placeholder', '.00');
    }else{
      console.log(budgetVal);
      // console.log(defaultCatId);
      $.ajax({
        dataType: 'json',
        url: 'app/support/addBudget.php',
        data:{'userId': userId, 'catId': defaultCatId, 'budget':budgetVal, 'month': thisMonth, 'year': thisYear},
        type: 'post',
        beforeSend: function(){
          $('.hf_loaderWrapper').fadeIn('fast');
        },
        complete: function(){
          $('.hf_loaderWrapper').fadeOut('fast');
        },
        success: function(data){
          console.log(data);
          if (data == false) {
            displayBudget(userId, defaultCatId, thisMonth, thisYear);
            calculatePercentageCat(userId, defaultCatId, thisMonth, thisYear);
            hideSetBudgetForm();
            showMonthlyBrief();
          }else if (data == true) {
            $('.hf_catSetBudgetInputNumber').css({'border-bottom-color':'red'});
          }
        }
      });
    }
  });

  $('.hf_catSetBudgetInputNumber').on('focus', function(){
    $(this).css({'border-bottom-color':'green'});
  });
  //SET BUDGET ENDS ============================================================

  //CLICK HEADINGS =============================================================
  $('.hf_coreContentHeadingIncome').on('click', function(){
    expense = false;
    $(this).css({'color':'#ffffff', 'background':'#486b00', 'cursor':'default'});
    $('.hf_coreContentTopBorder').css({'border-bottom-color':'#486b00'});
    $('.hf_coreContentHeadingExpenses').css({'background':'#e6e6e6', 'cursor':'pointer', 'color':'#666666'});
    showCategoryList(userId, expense);
  });
  $('.hf_coreContentHeadingExpenses').on('click', function(){
    expense = true;
    $(this).css({'color':'#ffffff', 'background':'#ff420e', 'cursor':'default'});
    $('.hf_coreContentTopBorder').css({'border-bottom-color':'#ff420e'});
    $('.hf_coreContentHeadingIncome').css({'background':'#e6e6e6', 'cursor':'pointer', 'color':'#666666'});
    showCategoryList(userId, expense);
  });
  // CLICK HEADINGDS END =======================================================

  //CLICK TRANSACTION BUTTON ===================================================
  $('.hf_extraHeadingButtonsTransactions').on('click', function(){
    clickTransactionButton();
  });
  //CLICK TRANSACTION BUTTON ENDS===============================================

  //CLICK OVERVIEW BUTTON ======================================================
  $('.hf_extraHeadingButtonsOverview').on('click', function(){
    clickOverviewButton();
  });
  //CLICK OVERVIEW BUTTON ENDS==================================================

  // DATE FUNCTIONS=============================================================

  // DATE FUNCTIONS OVER========================================================

  //MONTH SELECTOR FUNCTIONS ===================================================
  $('.hf_catExtraMonthArrow, .hf_catExtraMonthName').on('click', function(){
    $('.hf_months').show();
  });
  $('.hf_monthsClose').on('click', function(){
    $('.hf_months').hide();
  });
  $('.hf_monthsYearLeftArrow').on('click', function(){
    curYear = parseInt($('.hf_monthsYearYear').text().trim());
    $('.hf_monthsYearYear').text(curYear - 1);
  });
  $('.hf_monthsYearRightArrow').on('click', function(){
    curYear = parseInt($('.hf_monthsYearYear').text().trim());
    $('.hf_monthsYearYear').text(curYear + 1);
  });
  $('.hf_monthsMonths div').on('click', function(){
    thisMonth = $(this).data('month-no');
    var thisMonthName = $(this).text().trim();
    thisYear = parseInt($('.hf_monthsYearYear').text().trim());
    $('.hf_months').hide();
    $('.hf_catExtraMonthName').text(thisMonthName + ' ' + thisYear);
    setSelectedCategory(userId, defaultCatId, thisMonth, thisYear);
    displayBudget(userId, defaultCatId, thisMonth, thisYear);
    calculatePercentageCat(userId, defaultCatId, thisMonth, thisYear);
    showTransactions(userId, thisMonth, thisYear);
    showMonthlyBrief();
    showMonthlySummary(userId, thisMonth, thisYear);
    //console.log(thisMonth);
  });
  //MONTH SELECTOR FUNCTIONS END================================================

  //DELETE TRANSACTION =========================================================
  $(document).on('click', '.tr_delete',  function(){
    var transactionId = $(this).data('transaction-id');
    deleteTransaction(transactionId);
    //alert(transactionId);
  });
  //DELETE TRANSACTION ENDS ====================================================

  //MONTHLY SUMMARY BEGINS =====================================================
  $('.hf_ms_heading').text(thisMonth + '.' + thisYear);
  //MONTHLY SUMMARY ENDS =======================================================

  //CLICK CALANDAR BUTTONS =====================================================
  $(document).on('click', '.hf_noteAndDateRighti', function(){
    $('.hf_dateArrow').show();
  });
  $('.hf_calanderClose').on('click', function(){
    $('.hf_dateArrow').hide();
  });
  $(document).on('mouseup', function(e){
    var containerCal1 = $('.hf_dateArrow');
    if (!containerCal1.is(e.target) && containerCal1.has(e.target).length === 0)
    {
        containerCal1.hide();
    }

    var containerCal2 = $('.hf_months');
    if (!containerCal2.is(e.target) && containerCal2.has(e.target).length === 0)
    {
        containerCal2.hide();
    }
  });

  $(document).on('click', '.hf_calendarHeaderLeftArr', function(){
    $('.hf_dateArrow').show();
    displayCalandar(1);
  });

  $(document).on('click', '.hf_calendarHeaderRightArr', function(){
    $('.hf_dateArrow').show();
    displayCalandar(2);
  });

  $(document).on('click', '.enabledDays', function(){
    var date = $(this).text();
    var month = $('.hf_calendarHeaderMonthYear').data('month');
    var year = $('.hf_calendarHeaderMonthYear').data('year');
    var dateThis = date + '.' + month + '.' + year;
    $('.hf_date').text(dateThis);
    $('.hf_dateArrow').hide();
    //console.log(dateThis);
  });
  //CLICK CALANDAR BUTTONS END =================================================

  // SHOW HIDE SETTINGS ========================================================
  $('.hf_headingRight').on('click', function(){
    $('.hf_headingExtention').toggle();
  });
  $('.hf_headingExtentionBack').on('click', function(){
    $('.hf_headingExtention').hide();
  });
  // SHOW HIDE SETTINGS ENDS ===================================================

  // * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS

  //SELECT CATEGORY AJAX FUNCTIONS =============================================
  function setSelectedCategory(userId, catId, thisMonth, thisYear){
    $.ajax({
      dataType: 'json',
      url: 'app/support/changecat.php',
      data:{'userId': userId,'catId': catId, 'month': thisMonth, 'year': thisYear},
      type: 'post',
      beforeSend: function(){
        $('.hf_loaderWrapper').fadeIn('fast');
      },
      complete: function(){
        $('.hf_loaderWrapper').fadeOut('fast');
      },
      success: function(data){
        //console.log(data);
        $('.hf_catTotalAmount').text(data.totalAmount);
        $('.hf_categoryOverviewName').text(data.catName);
        $('.hf_categoryOverviewIcon .material-icons').text(data.catIcon);
        $('.hf_categoryOverviewIcon').css({'background':data.catColor});
        $('.hf_curCatName').text(data.catName);
        $('.hf_curCatIcon .material-icons').text(data.catIcon);
        if (data.catType == 1) {
          $('.hf_catTotalType').html('<i class="material-icons">trending_down</i>');
          $('.hf_catTotal').css({'color':'red'});
        }else if (data.catType == 0) {
          $('.hf_catTotalType').html('<i class="material-icons">trending_up</i>');
          $('.hf_catTotal').css({'color':'green'});
        }
        calculatePercentageCat(userId, catId, thisMonth, thisYear);
      }
    });
  }
  //SELECT CATEGORY AJAX FUNCTIONS ENDS ========================================

  //CALCULATE PERCENTAGE - CAT WISE=============================================
  function calculatePercentageCat(userId, catId, thisMonth, thisYear){
    $.ajax({
      dataType: 'json',
      url: 'app/support/calPercentCat.php',
      data:{'userId': userId,'catId': catId, 'month': thisMonth, 'year': thisYear},
      type: 'post',
      success: function(data){
        //console.log(data);
        $('.hf_categoryCircle').html(data.percentage + '%');
        if (data['catType'] == 1) {
          //expense
          if (data.percentage == 0) {
            $('.hf_categoryCircle').css({'background':'#666666'});
          }else if (data.percentage >=1 && data.percentage <=80) {
            $('.hf_categoryCircle').css({'background':'#52BE07'});
          }else if (data.percentage >=81 && data.percentage <=90) {
            $('.hf_categoryCircle').css({'background':'#EDAA0F'});
          }else if (data.percentage >=91 && data.percentage <=99) {
            $('.hf_categoryCircle').css({'background':'#ED5C0F'});
          }else if (data.percentage >=100) {
            $('.hf_categoryCircle').css({'background':'red'});
          }
        }else if (data['catType'] == 0) {
          //income
          $('.hf_categoryCircle').css({'background':'#0F7EED'});
        }
      }
    });
  }
  //CALCULATE PERCENTAGE - CAT WISE END=========================================

  //FUNCTION DISPLAY BUDGET ====================================================
  function displayBudget(userId, catId, thisMonth, thisYear){
    $.ajax({
      dataType: 'json',
      url: 'app/support/viewBudget.php',
      data:{'userId': userId,'catId': catId, 'month': thisMonth, 'year': thisYear},
      type: 'post',
      success: function(data){
        $('.hf_catBudgetContent').html(data);
      }
    });
  }
  //FUNCTION DISPLAY BUDGET ENDS ===============================================

  //FUNCTION HIDE SET BUDGET FORM ==============================================
  function hideSetBudgetForm(){
    $('.hf_catSetBudget').css({'display':'none'});
    $('.hf_catBudgetContent').fadeIn('fast');
    $('.hf_catSetBudgetInputNumber').val('');
  }
  //FUNCTION HIDE SET BUDGET FORM ENDS==========================================

  //FUNCTION CLICK TRANSACTION BUTTON ==========================================
  function clickTransactionButton(){
    $('.hf_extraHeadingButtonsTransactions').css({'background':'#EBA50F', 'color':'#ffffff'});
    $('.hf_extraHeading').css({'border-bottom-color': '#EBA50F'});
    $('.hf_extraHeadingButtonsOverview').css({'background':'#B1D2F4', 'color': '#666666'});
    $('.hf_extraHeadingButtons').css({'background':'#B1D2F4'});
    $('.hf_catExtra').hide();
    $('.hf_transactionsExtra').show();
  }
  //FUNCTION CLICK TRANSACTION BUTTON ENDS======================================

  //FUNCTION CLICK TRANSACTION BUTTON ==========================================
  function clickOverviewButton(){
    $('.hf_extraHeadingButtonsTransactions').css({'background':'#FEEFCF', 'color':'#333333'});
    $('.hf_extraHeading').css({'border-bottom-color': '#0F7EED'});
    $('.hf_extraHeadingButtonsOverview').css({'background':'#0F7EED', 'color': '#ffffff'});
    $('.hf_extraHeadingButtons').css({'background':'#FEEFCF'});
    $('.hf_transactionsExtra').hide();
    $('.hf_catExtra').show();
  }
  //FUNCTION CLICK TRANSACTION BUTTON ENDS======================================

  // FUNCTION SHOW TRANSACTIONS ================================================
  function showTransactions(userId, thisMonth, thisYear){
    $.ajax({
      //dataType: 'json',
      url: 'app/support/viewTransactions.php',
      data:{'userId': userId, 'month': thisMonth, 'year': thisYear},
      type: 'post',
      success: function(data){
        $('.hf_transactionHistory').html(data);
      }
    });
  }
  // FUNCTION SHOW TRANSACTIONS ENDS ===========================================

  //FUNCTION DELETE TRANSACTION ================================================
  function deleteTransaction(transactionId){
    $.ajax({
      //dataType: 'json',
      url: 'app/support/deleteTransactions.php',
      data:{'transactionId': transactionId},
      type: 'post',
      beforeSend: function(){
        $('.hf_loaderWrapper').fadeIn('fast');
      },
      complete: function(){
        $('.hf_loaderWrapper').fadeOut('fast');
      },
      success: function(data){
        if(data == 'success'){
          setSelectedCategory(userId, defaultCatId, thisMonth, thisYear);
          displayBudget(userId, defaultCatId, thisMonth, thisYear);
          calculatePercentageCat(userId, defaultCatId, thisMonth, thisYear);
          showTransactions(userId, thisMonth, thisYear);
          showMonthlySummary(userId, thisMonth, thisYear);
          showMonthlyBrief();
        }else{
          // console.log('error');
        }
      }
    });
  }
  //FUNCTION DELETE TRANSACTION ENDS ===========================================

  //FUNCTION SHOW SUMMARY ======================================================
  function showMonthlySummary(userId, thisMonth, thisYear){
    $.ajax({
      dataType: 'json',
      url: 'app/support/showSummary.php',
      data:{'userId': userId, 'month': thisMonth, 'year': thisYear},
      type: 'post',
      success: function(data){
        $('.hf_monthlySummaryBodyIncome').text((data.income));
        $('.hf_monthlySummaryBodyExpenses').text(data.expenses);
        $('.hf_monthlySummaryBodyBalance').text(data.balance);
        $('.hf_ms_expensesDetailsActualDetail span').text(data.expenses);
        $('.hf_ms_incomeDetailsActualDetail span').text(data.income);
        if(data.balance < 0){
          $('.hf_monthlySummaryBodyBalance').css({'color':'red'});
        }else{
          $('.hf_monthlySummaryBodyBalance').css({'color':'green'});
        }

      }
    });
  }
  //FUNCTION SHOW SUMMARY ENDS =================================================

  //FUNCTION SHOW CATEGORY LIST ================================================
  function showCategoryList(userId, expense, setDefault = 1){
    //console.log(setDefault);
    $.ajax({
      dataType: 'json',
      url: 'app/support/showCategoryList.php',
      data:{'userId': userId, 'expense': expense},
      type: 'post',
      success: function(data){
        $('.hf_categories').html(data.htmlcontent);
        //console.log(defaultCatId);
        if (setDefault == 1) {
          defaultCatId = data.catId;
        }
        setSelectedCategory(userId, defaultCatId, thisMonth, thisYear);
        displayBudget(userId, defaultCatId, thisMonth, thisYear);
      }
    });
  }
  //FUNCTION SHOW CATEGORY LIST ENDS ===========================================

  //FUNCTION ADD NEW CATEGORY ==================================================
    function showNewCatIcons(){
      showAddNewCategory();
      $.ajax({
        //dataType: 'json',
        url: 'app/support/showNewCatIcons.php',
        data:{'userId': userId, 'expense': expense},
        type: 'post',
        success: function(data){
          $('.newCategoryContentInner').html(data);
          //console.log(data);
        }
      });
    }
  //FUNCTION ADD NEW CATEGORY ENDS =============================================

  //SHOW ADD A NEW CATEGORY ====================================================
    function showAddNewCategory(){
      $('.hf_categories').slideUp('fast', function(){
          $('.newCategory').slideDown();
      });
    }
  //SHOW ADD A NEW CATEGORY ENDS ===============================================

  //HIDE ADD A NEW CATEGORY ====================================================
    function hideAddNewCategory(){
      $('.newCatIcon .material-icons').text('add');
      $('.newCatIcon').css({'background':'#999999', 'border-color':'#333333', 'color':'#000000'});
      $('.newCatNameInput').css({'border-color':'#999999', 'color':'#000000'});
      $('.newCatNameInput').val('');
      $('.newCatIcon').data('icon', 'add');
      $('.newCategory').slideUp('fast', function(){
          $('.hf_categories').slideDown();
      });
    }
  //HIDE ADD A NEW CATEGORY ENDS ===============================================

  //SUNCTION SHOW MONTHLY BRIEF ================================================
  function showMonthlyBrief(){
    $.ajax({
      dataType: 'json',
      url: 'app/support/showMonthlySummary.php',
      data:{'userId': userId, 'month': thisMonth, 'year':thisYear},
      type: 'post',
      success: function(data){
        $('.hf_ms_expensesDetailsBudgetDetail span').text(data.expense);
        $('.hf_ms_incomeDetailsBudgetDetail span').text(data.income);
        //alert(data.expense);
        var actualExpense = $('.hf_ms_expensesDetailsActualDetail span').text().replace(',', '');
        var actualExpensePositive = parseInt(actualExpense) * -1;
        var expensePerc = parseInt(actualExpensePositive/(data.expense).replace(',', '')*100);
        if(isNaN(expensePerc)){
          $('.hf_ms_expensePercentage').text('0%');
        }else{
          $('.hf_ms_expensePercentage').text(expensePerc + '%');
        }


        if(expensePerc <= 100){
          $('.hf_ms_expensesDetailsActualGraph').css({'width':expensePerc + '%'});
          $('.hf_ms_expensesDetailsBudgetGraph').css({'width':'100%'});
        }else{
          var budgetGraphWidth = ((data.expense).replace(',', '')*100)/actualExpensePositive;
          $('.hf_ms_expensesDetailsActualGraph').css({'width':'100%'});
          $('.hf_ms_expensesDetailsBudgetGraph').css({'width':budgetGraphWidth +'%'});
        }

        var actualIncome = parseInt($('.hf_ms_incomeDetailsActualDetail span').text().replace(',', ''));
        var incomePerc = parseInt(actualIncome/(data.income).replace(',', '')*100);
        if (isNaN(incomePerc)) {
          $('.hf_ms_incomePercentage').text('0%');
        }else{
          $('.hf_ms_incomePercentage').text(incomePerc + '%');
        }

        if(incomePerc <= 100){
          $('.hf_ms_incomeDetailsActualGraph').css({'width':incomePerc + '%'});
          $('.hf_ms_incomeDetailsBudgetGraph').css({'width':'100%'});
        }else{
          var budgetGraphWidth2 = ((data.income).replace(',', '')*100)/actualIncome;
          $('.hf_ms_incomeDetailsActualGraph').css({'width':'100%'});
          $('.hf_ms_incomeDetailsBudgetGraph').css({'width':budgetGraphWidth2 +'%'});
        }
        //console.log(test);
      }
    });
  }
  //FUNCTION SHOW MONTHLY BRIEF OVER ===========================================

  //FUNCTION DISPLAY CALANDAR ==================================================
  function displayCalandar(butClicked = 0){
    var thisMonth = $('.hf_calendarHeaderMonthYear').data('month');
    var thisYear = $('.hf_calendarHeaderMonthYear').data('year');
    $.ajax({
      dataType: 'json',
      url: 'app/support/displayCalandar.php',
      data:{'month': thisMonth, 'year':thisYear, 'but':butClicked},
      type: 'post',
      success: function(data){
        $('.hf_calendarHeaderMonthYear').data('month', data.monthNumber);
        $('.hf_calendarHeaderMonthYear').data('year', data.year);
        $('.hf_calendarHeaderMonthYear').text(data.monthName + ' ' + data.year);
        $('.hf_calandarDates').html(data.htmlDivs);
        //console.log(data);
      }
    });
    //console.log(thisMonth);
  }
  //FUNCTION DISPLAY CALANDAR ENDS =============================================

  //FUNCTION PERCENTAGE DISPLAY CAT ============================================
  // function percentageDisplayCat(){
  //   var pdcBudget = $('.hf_catBudgetContent').html();
  // }
  //FUNCTION PERCENTAGE DISPLAY CAT ENDS =======================================

  // * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS * FUNCTIONS
});
