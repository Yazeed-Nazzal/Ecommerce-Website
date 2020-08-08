<?php 
function lang($phrase) {
 static $lang = array (
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
     "Home"          => "Home",
     "Gategories"    => "Gategories",
     "item"          => "Items",
     "members"       => "Members",
     "comments"       => "Comments",
     "statistics"    => "Statistics",
     "logs"          => "Logs", 
     "visit shop"    => "Visit Shop",
     "Edit profile"  => "Edit profile",
     "Setting"       => "Setting",
     "logout"        => "Logout",
     "dashboard"     => "Dashboard"
     //navbar
 );
 return $lang[$phrase];
}
?>