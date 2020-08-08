<?php
session_start();
if(isset($_SESSION['username'])){
    $pagetitle = "dashboard";
   include "init.php";
   include "Inclodes/templates/footer.php";

?>
<div class = "container dash">
        <h3 class = " dashh3">Dashboard</h3>
        <div class="row">
                <div class=" col-sm dashlist">
                        <a class="row Tmember" href="member.php">
                                 <div class="ficon"><i class="fas fa-users"></i></div>
                                 <div class="textfi">total members</div>
                                 <div class="numfi"><?php echo getcount("UserID","users"); ?></i></div>
                        </a>
                        <a  href="member.php?do=manage&page=pending" class="row Pmember">
                                 <div class="ficon"><i class="fas fa-user-clock"></i></div>
                                 <div class="textfi">pending members</div>
                                 <div class="numfi"><?php echo getcount("UserID","users"," where RegStatus =0"); ?></div> 
                        </a>
                 
                        <a href="items.php" class="row Titem">
                                 <div class="ficon"><i class="fas fa-boxes"></i></div>
                                 <div class="textfi">total itams</div>
                                 <div class="numfi"><?php echo getcount("ItemID","items",""); ?></div>
                        </a>
                        <a href="comments.php" class="row Tcomment">
                                 <div class="ficon"><i class="fas fa-comments"></i></div>
                                 <div class="textfi">total comment</div>
                                 <div class="numfi"><?php echo getcount("Comment_ID","comments",""); ?></i></div>
                        </a>
                </div>
                <div class="col-sm imgcol">
                        <div class="row dashimg">
                                 
                        </div>  
               </div>
        </div>
        <div  class ="row lastes">
                <div class="col-sm lasu">
                        <p class = "lasp"><i class="fas fa-users dashfa"></i> lastes User</p>
                        <ul>
                        <?php
                        $lastestuser = getlastest('users','RegesterDate');
                        foreach($lastestuser as $V){
                                ?>
                                <li class = "dashuser"><?php echo $V['UserName']?>
                                         <a type="button" class="btn float-right pull-right debt" href="member.php?do=Edit&userid=<?php echo $V['UserID'] ?>" > <i class="fas fa-edit"></i>Edit</a>
                                         <?php

                                         if ($V['RegStatus']==0) {
                                                 ?>
                                                <a type="button" class="btn float-right pull-right dabt" href="member.php?do=Activate&userid=<?php echo $V['UserID']?>"> Activate</a>
                                         <?php
                                        }
                                         ?>

        
                                       
                                </li>
                        <?php
                        }
                        ?>
                        </ul>
                </div>
                <div class="col-sm lasi">
                        <p class = "lasp"><i class="fas dashfa fa-tags"></i> lastes items</p>
                        <ul>
                        <?php
                        $lastestuser = getlastest('items','Date');
                        foreach($lastestuser as $V){
                                ?>
                                <li class = "dashuser"><?php echo $V['ItemName']?>
                                         <a type="button" class="btn float-right pull-right debt" href="items.php?do=Edit&itemid=<?php echo $V['ItemID'] ?>"> <i class="fas fa-edit"></i>Edit</a>
                                        <?php
                                         if ($V['approve']==0) {
                                                 ?>
                                                <a type="button" class="btn float-right pull-right dabt" href="items.php?do=approve&itemid=<?php echo $V['ItemID']?>"><i class="fas fa-check"></i>Approve</a>
                                         <?php
                                        }
                                        ?>
                                </li>
                        <?php
                        }
                        ?>
                        </ul>
                  
                </div>
        </div>

<?php 
}
else 
{
    header('Location: index.php');
    exit();
}
?>