$(document).ready(function(){
  $('.legalTextsImprint').on('click', function(){
    $('.aLegalText').hide();
    $('.imprint').toggle('slow');
  });

  $('.legalTextsTac').on('click', function(){
    $('.aLegalText').hide();
    $('.tac').toggle('slow');
  });

  $('.legalTextsPp').on('click', function(){
    $('.aLegalText').hide();
    $('.pp').toggle('slow');
  });

  $('.aLegalTextClose').on('click', function(){
    $('.aLegalText').hide('slow');
  });
});
