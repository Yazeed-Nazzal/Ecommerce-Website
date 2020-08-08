<?php
ob_start();
session_start();
$pagetitle = "login";
if(isset($_SESSION['user'])){
 
    header('Location:index.php');
    exit();
}
include "init.php";
if ($_SERVER['REQUEST_METHOD']=='POST') {
        if (isset($_POST['login'])) {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $hashedpass = sha1($password);
            try {
                $stmt = $con->prepare("SELECT UserID, UserName,Password  FROM `users` WHERE UserName=? AND Password = ?  LIMIt 1 ");
                $stmt->execute(array($username,$hashedpass));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                }
                catch (Exception $e){
                    echo $e;
                    }
                if ($count>0){
                      $_SESSION['user'] = $username;
                      $_SESSION['userid'] = $row['UserID'];
                      header('Location:index.php');
                      exit();
                }
                else
                {
                  echo "you have to wait your request under to join us study by admin";
                }
        }
        if (isset($_POST['signup'])) {
            $username   =$_POST['username'];
            $password   =$_POST['password'];
            $email      =$_POST['email'];
            $repassword = $_POST['repassword'];
            $fullname   = $_POST['fullname'];
            $formerror  = array();

            //start username check
            if (isset($_POST['username'])) {
              $filteruser = filter_var($username,FILTER_SANITIZE_STRING);
              if ($filteruser=='') {
                $formerror[]='you have to put your user name';
              }
              if (strlen($filteruser)<4) {
                $formerror[]='The user name shuld be more than 4 charactar';
              }
            }
            
            try {
            $stmt = $con->prepare("select *  From users WHERE UserName=?");
            $stmt->execute(array($username));
            $row = $stmt->rowCount();
            }
            catch (Exception $e){

            }
            if ($row > 0) {
              $formerror[] = "This username is allredy used";
          }
            //end username check
            //start password check
            if (empty($password)) {
              $formerror[]='you must enter a password';
            }
            else
            {
              $hashedpass = sha1($password);
            }
            if (isset($_POST['password']) && isset($_POST['repassword'])) {

                  if ($password != $repassword) {
                    $formerror[]='the password is not similar';
                  }
                  
                  if (strlen($password)< 6) {
                    $formerror[]='the password long enough';
                  }
              

            }
            //end password check
            //start check email 
            if (isset($_POST['email'])) {
              $filteremail = filter_var($email,FILTER_SANITIZE_EMAIL);
              
              if (filter_var($filteremail , FILTER_VALIDATE_EMAIL) != true) {
                $formerror[]='Not Valid Email';
              }
            }
            //end check email 
            

            if (count($formerror)>0) {
             foreach($formerror as $v){
              ?>
              <div class="container updiv ">
                  <i class="fas fa-exclamation-triangle"></i>
                  <?php foreach ($formerror as $v) {
                      echo "<div>" . $v . "</div>";
                  }
                  ?>
              </div>

          <?php
           header("refresh:5;url=login.php");
             }
            }
            else
            {
              $stmt = $con->prepare("INSERT INTO `users` ( `UserName`, `Password`, `FullName`, `Email` ,RegesterDate ,RegStatus) VALUES (?,?,?,?,now(),0)");
              $stmt->execute(array($username, $hashedpass, $fullname, $email));
              ?>
              <div class="container updiv ">
                  <i class="fas fa-thumbs-up"></i>
                  <?php echo "<div >success</div>"; ?>
              </div>
          <?php
              header("refresh:5;url=login.php");
              
              
            }
            

          
        }
      
}
else {
 
?>
<div id="back">
  <div class="backRight"></div>
  <div class="backLeft"></div>
</div>

<div id="slideBox">
  <div class="topLayer">
      <!-- start sign up -->
    <div class="left">
      <div class="content">
        <h2>Sign Up</h2>
        <form  action="<?php echo $_SERVER['PHP_SELF']?>"  method="POST">
          <div class="form-group">
            <input type="text" name="username" autocomplete="off" pattern=".{4,11}" title="you must enter more than 4 char" required placeholder="Enter Your UserName" />
          </div>
          <div class="form-group">
            <input type="text" name="fullname" autocomplete="off" required placeholder="Enter Your full name" />
          </div>
          <div class="form-group">
            <input type="text" name="password" autocomplete="off"  pattern=".{6,30}" title="you must enter more than 6 char" required placeholder="Enter Your password" />
          </div>
          <div class="form-group">
            <input type="text" name="repassword" autocomplete="off"  required placeholder="Rewrite Your Password" />
          </div>
          <div class="form-group">
            <input type="email" required autocomplete="off" name="email" placeholder="Enter Your Email" />
          </div>
          <input class ="sub" id="login" type="submit" value="SinUp" name="signup">
          <span id="goLeft" class="off">Login</span>
        </form>
       
      </div>
    </div>
    <!-- end sign up --> 
     <!-- ======================================================================================== -->
    <div class="right">
      <div class="content">
        <h2>Login</h2>
        <form  action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
          <div class="form-group">
            <label  class="form-label">Username</label>
            <input type="text" autocomplete="off" required name="username" />
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <br>
            <input type="password" required  name="password" />
          </div>
     
          <span  id="goRight" class="off">Sign Up</span>
          <input class ="sub" id="login" name="login"  type="submit" value="Login">
        </form>
      </div>
    </div>
  </div>
</div>
<?php
}

include ($temp."/footer.php");
ob_end_flush();
?>