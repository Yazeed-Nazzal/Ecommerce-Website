<?php 
function lang($phrase) {
 static $lang = array (
     "add ads"       => "add ads",
     "edit"          => "Edit",
     "login"         => "Login",
     "defult"        => "Defulte",
     'manage'        => "Manage",
     'update'        => "Update",
     'add'           => "Add",
     'insert'        => "insert",
     'delete'        => "delete",
     'error'         => "error",
     'Activate'      => "Activate",
     'Categories'    =>"Categories",
     'items'         =>"Items",
     //navbar
     'visit shop'    =>"visit shop",
     'Home Page'     => "Home Page",
     'home page'     => "Home Page",
     "Home"          => "Home",
     "Gategories"    => "Gategories",
     "item"          => "Items",
     "members"       => "Members",
     "comments"      => "Comments",
     "statistics"    => "Statistics",
     "logs"          => "Logs", 
     "Edit profile"  => "Edit profile",
     "Setting"       => "Setting",
     "logout"        => "Logout",
     "dashboard"     => "Dashboard",
     //navbar
     //profile
     "profile"      => "profile"
 );
 return $lang[$phrase];
}
?>