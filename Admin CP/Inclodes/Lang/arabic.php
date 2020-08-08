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
   //  navbar
    "Home"          => "الرئيسية",
    "Gategories"    => "القوائم",
    "item"          => "الادوات",
    "members"       => "الاعضاء",
    "visit shop"    => "زيارة السوق",
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