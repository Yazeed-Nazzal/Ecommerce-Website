<?php
session_start();
$nonavbar='';
$pagetitle = "login";
// remember the user
if(isset($_SESSION['username'])){
    header('Location:dashboard.php');
    exit();
}
include "init.php";
// check if user coming from post request
if($_SERVER['REQUEST_METHOD']=='POST'){
$username = $_POST["user"];
$password = $_POST["password"];
$hashedpass = sha1($password);
// check if the user exist in DB
    try {
    $stmt = $con->prepare("SELECT UserID, UserName,Password  FROM `users` WHERE UserName=? AND Password = ? AND GroupID=1 LIMIt 1 ");
    $stmt->execute(array($username,$hashedpass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    }
    catch (Exception $e){
        echo $e;
        }
    if ($count>0){
          echo "welcome" . $username;
          $_SESSION['username'] = $username;
          $_SESSION['ID']       = $row[0];
          $_SESSION['password'] = $row[2];
          header('Location:dashboard.php');
          exit();
    }
   
    

}

?> <div class="logindiv" >
        <form class="login input-group-mb text-center" action="<?php echo $_SERVER['PHP_SELF']?>" method='Post'>
            <i class="fas fa-user-cog pers"></i>
            <h4 class="text-center"> Admin login</h4>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-user"></i></span>
                </div>
                <input  type="text" class="form-control"  autocomplete="off" placeholder="Username" name="user">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control" autocomplete="off" placeholder="Password" name="password">
            </div>  
            <input  type="submit" class="btn btn-primary btn-block " autocomplete="new-password" value="Login">
        </form>
    </div>
<?php
include $temp."/footer.php";
?>