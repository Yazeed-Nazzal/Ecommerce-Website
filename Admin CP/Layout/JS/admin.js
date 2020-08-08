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

$("select").selectBoxIt();
// categories view 
$(".full").click(function () {
   $(".vis").css("display","inline");
   $(this).css("color","#c75013")
   $(".classic").css("color","#fff");
})

$(".classic").click(function () {
   $(this).css("color","#c75013")
   $(".full").css("color","#FFF");
   $(".vis").css("display","none");
});

//show delete a
$(".link-child").hover(function () {
       $(this).find(".show-delete").fadeIn(400);

},function () {
   $(this).find(".show-delete").fadeOut(400);
});






});