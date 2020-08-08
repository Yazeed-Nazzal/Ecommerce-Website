<?php
ob_start();
session_start();
$pagetitle = "items";
include "init.php";
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? $_GET['itemid'] :-1;

$query = $con->prepare("SELECT items.* ,categories.CatName , categories.CatID,  users.UserName ,users.UserID FROM items
                                         INNER JOIN categories on categories.CatID = items.Cat_ID
                                          INNER JOIN users on users.UserID=items.User_ID WHERE ItemID= ? and approve =1 
                                                        ");
$query->execute(array($itemid));
$row = $query->fetch();
$count = $query->rowCount();

if ($count > 0) {
 ?>
        <h3 class = "itemh  text-center"><?php echo $row["ItemName"] ?> </h3>
        <div class ="container">
            <div class="row">
                <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        Item Information
                    </div>
                    <div class="card-body nthbody">

                        <p><i class="fas fa-user-lock"></i>Item Name:<span> <?php echo " " . $row['ItemName'] ?></span></p>
                        <p><i class="fas fa-user"></i>Description :<span><?php echo " " . $row['Description'] ?></span> </p>
                        <p><i class="fas fa-envelope"></i>Price :<span><?php echo " " . $row['Price'] ?></span> </p>
                        <p><i class="fas fa-calendar-alt"></i>Add Date :<span><?php echo " " . $row['Date'] ?></span></p>
                        <p><i class="fas fa-flag"></i>MadeCountry :<span><?php echo " " . $row['MadeCountry'] ?></span></p>
                        <p><i class="fas fa-user"></i>ADD By :<span><a class="cata" href="#"><?php echo " " . $row['UserName'] ?></a></span></p>
                        <p><i class="fas fa-archive"></i>Category :<span><a class="cata" href="categories.php?pageid=<?php echo $row['CatID']?>&pagename= <?php echo $row['CatName'] ?>"><?php echo " " . $row['CatName'] ?></a></span></p>
                 

                    </div>
                </div>

                </div>
                <div class="col-md-5">
                <img src="uploads\items\<?php echo $row['Image']?>" alt="..." class="img-thumbnail ">
                </div>

            </div>

        </div>
       
        <div class="container">
        <hr class="itemhr">
            <?php
            if(isset($_SESSION['user'])){
                ?>
                <div class="row">
                <div class="col-md-9">
              
                        <h3 class="comh">Add your comment</h3>
                        <form class="commentform " method="POST" action="<?php  echo "items.php?itemid=".$row['ItemID']."&pagename=".$row["ItemName"] ?>">
                            <textarea required name="com" id="" cols="30" rows="2"></textarea>
                            <br>
                            <input  class="commentsub sub" value="Comment" type="submit">
                        </form>
                        <?php
                        if($_SERVER['REQUEST_METHOD']=="POST"){
                           $com = $_POST['com'];
                           $userid = $sessionuser;

                           if(empty($com)){
                              echo  "you should put a comment";
                           }
                           else{
                            echo  "your comment is send and wait for approve";
                           $com = filter_var($com,FILTER_SANITIZE_STRING);
                           $query = $con->prepare("INSERT INTO comments (`Comment`,`Com_Date`,`item_id`,`user_id`,`Status`) VALUES(?,NOW(),?,?,0)");
                           $query->execute(array($com,$itemid,$userid));

                           }

                        }

                        ?>
                </div>
                <div class="col-md-3 commentaddimg" >

                </div>

            </div>
            <?php

            }
            else{
                ?>
                <p><a class="cata" href="login.php">login</a> or <a class="cata" href="login.php">register</a> to add comment</p>
                <?php
            }
            ?>
       
         
            <hr class="itemhr">
            <?php
            $stmt = $con->prepare("SELECT comments.* , users.UserName , users.avatar FROM comments
                                                                                   INNER JOIN users ON users.UserID = comments.user_id
                                                                                   WHERE item_id = ? AND  Status = 1
                                                                                    ORDER BY Com_Date ASC");
                $stmt->execute(array($itemid));
                $rows = $stmt->fetchAll();
                foreach($rows as $comment){
                    ?>
                        <div class ="row">
                                <div class ="col-md-2 comentinfo">
                                <img src="Admin CP\uploads\avatar\<?php echo $comment['avatar'] ?>" alt="..." class="   img-thumbnail rounded-circle img-fluid comimg ">
                                <span><?php  echo $comment['UserName']?></span>
                                  </div>
                                <div class = "col-md-8 commentdata">
                                         <span><?php echo $comment['Comment'] ?></span>
                                </div>
                        </div>
                        


                    <?php
                    

                }
               ?>
             
              

          

        </div>

<?php
}

else
{
    ?>
    <i class="fas fa-dog dog d-flex justify-content-center"></i>
    <p class="dogp  d-flex justify-content-center">Not Allwed</p>
    <?php
    header("refresh:7;url=profile.php");
    
}









include $temp ."/footer.php";
ob_end_flush();



?>