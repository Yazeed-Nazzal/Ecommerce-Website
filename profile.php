<?php
session_start();
$pagetitle = "profile";
include "init.php";
if (isset($_SESSION['user'])) {
    $query = $con->prepare("SELECT * FROM users WHERE UserID = ? limit 1");
    $query->execute(array($sessionuser));
    $row = $query->fetch();
?>
    <div class="container">
        <h2 class="profh text-center">welcome back <?php echo $_SESSION['user'] ?></h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="float-left">my information</h3>
                        <a class="profile-edit float-right" href="#">edit</a>
                        <div class="clear"></div>
                    </div>
                    <div class="card-body nthbody">

                        <p><i class="fas fa-user-lock"></i>UserName :<span> <?php echo " " . $row['UserName'] ?></span></p>
                        <p><i class="fas fa-user"></i>FullName :<span><?php echo " " . $row['FullName'] ?></span> </p>
                        <p><i class="fas fa-envelope"></i>Email :<span><?php echo " " . $row['Email'] ?></span> </p>
                        <p><i class="fas fa-calendar-alt"></i>Register Date :<span><?php echo " " . $row['RegesterDate'] ?></span></p>
                        <p><i class="fas fa-tags"></i>Favoreat Categories<span></span></p>
                        

                    </div>
                </div>

            </div>
            <?php

            $query = $con->prepare("SELECT * FROM `comments` where user_id = ? ");
            $query->execute(array($sessionuser));
            $row = $query->fetchALL();

            ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Lastest Comments</h3>
                    </div>
                    <div class="card-body nthbody ">


                        <?php
                        foreach ($row as $v) {
                        ?>
                            <p><?php echo $v['Comment']  ?></p>
                        <?php

                        }

                        ?>


                    </div>
                </div>

            </div>

        </div>
        <div class="row" id="my-ads">
            <div class="col-md-12">
                <?php
                $record = getitems("User_ID", $sessionuser);
                ?>
                <div class="card adscard">
                    <div class="card-header">
                        <h3>my ADS</h3>
                    </div>
                    <div class="card-body pcard">
                        <div class="row">
                            <?php
                            if (count($record)>0) {
                                foreach ($record as $v) {
                                    ?>
                                        <div class="col-md-6 col-6   col-lg-3" >
                                            <div class="thumbnail pthumb  float-left">
                                               <span class ="pricr-tag"><?php echo $v['Price'] ?> $</span>
                                               <?php
                                               if ($v['approve']==0) {
                                                   echo " <span class ='approvespan'>waiting for approve</span>" ;
                                                   
                                               }

                                               ?>
                                                <img src="uploads\items\<?php echo $v['Image']?>" alt="..." class="img-thumbnail ">
                                                <div class="caption">
                                                    <h4><a class="itema" href="items.php?itemid=<?php echo $v['ItemID'] ?>"> <?php echo $v['ItemName']; ?> </a></h4>
                                                    <p><?php echo $v['Description']; ?></p>
                                                    <p class="float-right idate"><?php echo $v['Date']; ?></p>
        
                                                </div>
                                            </div>
                                        </div>
        
                                    <?php
                                    }
                            }
                            else
                            {
                             ?>
                             <p>No Ads to show Create,<a class="newAD" href="newad.php">New AD</a></p>
                             <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    <?php
} else {

    ?>
        <i class="fas fa-dog dog d-flex justify-content-center"></i>
        <p class="dogp  d-flex justify-content-center">not allwed</p>

    <?php
    header("refresh:5;url=login.php");
}
include $temp . "/footer.php";
    ?>