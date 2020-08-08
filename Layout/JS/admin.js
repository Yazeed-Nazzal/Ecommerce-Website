$(function () {
'use strict';
// hide placeholder
$('[placeholder]').focus(function () {
$(this).attr('data-text',$(this).attr('placeholder'));
$(this).attr('placeholder','');
}).blur(function () {
   $(this).attr('placeholder',$(this).attr('data-text'));
});

// hide placeholder

//--------------------------------------------------------------

//password show
$(".fa-eye").hover(function () {
   $(".sh").attr('type','text');
   $(this).addClass("fa-eye-slash");
},function () {
   $(".sh").attr('type','password');
   $(this).removeClass("fa-eye-slash");
}
);
//password show

//--------------------------------------------------------------

//delete confirmation

$(".confirm").click(function () {
      return confirm("Are you sure you want to delete this user ");
});

//lohin animation

$("select").selectBoxIt();
   $('#goRight').on('click', function(){
     $('#slideBox').animate({
       'marginLeft' : '0'
     });
     $('.topLayer').animate({
       'marginLeft' : '100%'
     });
   });
   $('#goLeft').on('click', function(){
     $('#slideBox').animate({
       'marginLeft' : '50%'
     });
     $('.topLayer').animate({
       'marginLeft': '0'
     });
   });

  //live edit
  $(".live-name").keyup(function () { 
    $(".prview-name").text($(this).val());
  });
  $(".live-des").keyup(function () { 
    $(".prview-des").text($(this).val());
  });
  $(".live-price").keyup(function () { 
    $(".prview-price").text("$"+$(this).val());
  });
  
//comment add alert







});