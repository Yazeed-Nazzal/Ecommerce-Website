<?php 
function lang($phrase) {
 static $lang = array (
   "edit"          => "تعديل",
   "login"         => "تسجيل الدخول",
   "defult"        => "قياسي",
   'manage'        => "ادراة",
   'update'        => "تعديل",
   'add'           => "اضافة",
   'delete'        => "حذف",
   'error'         => "خطأ",
   'Activate'      => "تفعيل",
   'Categories'    =>"الأقسام",
   "add ads"       => "اضافة اعلان",
   
   //  navbar
   'visit shope'   =>"زساؤة المتجر",
    "Home"          => "الرئيسية",
    'home page'     => "الصفحة الارئيسية",
    "Gategories"    => "القوائم",
    "item"          => "الادوات",
    "members"       => "الاعضاء",
    "comments"       => "التعليقات",
    "statistics"    => "الاصحائيات",
    "logs"          => "التسجيلات", 
    "Edit profile"  => "تعديل حسابك",
    "Setting"       => "الاعدادات",
    "dashboard"     => "اللوحة الرئيسية",
    "logout"        => "خروج"
   //navbar
 );
 return $lang[$phrase];
}
?>