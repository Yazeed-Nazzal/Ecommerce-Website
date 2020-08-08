<?php

//  ============================================
//  = This page to edit and add and manage members
//  = 
//  ===========================================
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    // rename the title
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    $pagetitle = "member";
    if ($do == 'manage') {
        $pagetitle = "manage";
    } elseif ($do == 'Edit') {
        $pagetitle = "edit";
    } elseif ($do == 'update') {
        $pagetitle = "update";
    } elseif ($do == 'add') {
        $pagetitle = "add";
    } elseif ($do == 'insert') {
        $pagetitle = "insert";
    } elseif ($do == 'delete') {
        $pagetitle = "delete";
    } elseif ($do == 'Activate') {
        $pagetitle = "Activate";
    } else {
        $pagetitle = "error";
    }

    // end rename the title
    //----------------------------------------------
    include "init.php";
    //====================
    //===sratr manage
    //====================
    if ($do == 'manage') {
        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {
            $query = ' And RegStatus = 0';
        }
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1" . $query);
        $stmt->execute();
        $rows = $stmt->fetchAll();


?>

        <div class="container manc">
            <h3 class="text-center">manage member</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">user name</th>
                        <th scope="col">user IMage</th>
                        <th scope="col">email</th>
                        <th scope="col">FullName</th>
                        <th scope="col">Reg date</th>
                        <th scope="col">control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<th  scope='col'>";
                        echo $row['UserID'];
                        echo "</th>";
                        echo "<td  scope='col'>";
                        echo $row['UserName'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                            ?>
                                <img style="width: 80px" class="rounded-circle userimg" src="uploads\avatar\<?php echo$row['avatar'] ?>" alt="user img">
                            <?php
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['Email'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['FullName'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['RegesterDate'];
                        echo "</td>";
                    ?>
                        <td>
                            <a type="button" class="btn ted" href="<?php echo "?do=Edit&userid=" . $row['UserID'] ?>"><i class="fas fa-edit"></i>Edit </a>
                            <a type="button" class="btn tre confirm " href="<?php echo "?do=delete&userid=" . $row['UserID'] ?>"> Delete <i class="fas fa-user-times"></i></a>
                            <?php
                            if ($row['RegStatus'] == 0) {
                            ?>
                                <a type="button" class="btn tac" href="?do=Activate&userid=<?php echo $row['UserID']?>">Activate</a>
                            <?php
                            }
                            ?>
                        </td>
                    <?php
                        echo "</tr>";
                    }

                    ?>

                </tbody>
            </table>
            <a class="btn tre" href="?do=add"><i class="fas fa-user-plus"></i>Add New Member </a>
        </div>

        <?php
    }
    //====================
    //===end manage
    //====================

    //----------------------------------------------

    //====================
    //===sratr edit
    //====================
    elseif ($do == 'Edit' && isset($_GET['userid'])) {

        $pagetitle = "edit";
        // get the user id from the link and check it 
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : -1;


        // get the data from data base
        try {

            $stmt = $con->prepare("SELECT * FROM `users` WHERE UserID=?  LIMIt 1 ");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
           
            $count = $stmt->rowCount();
            
        } catch (Exception $e) {
           
        }

        //check the user id  to previwe the edit page
        if ($_GET['userid'] == $_SESSION['ID'] || ($count > 0 && ($row['GroupID'] != 1))) {
        ?>

            <div class="container">
                <h2 class="d-flex justify-content-start edh">Edit Member</h2>
            </div>

            <div class="container edcon">
                <div class="row">
                    <form class="col-sm" action="?do=update" method="POST">

                        <input type="hidden" name='userid' value="<?php echo $row[0] ?> ">
                        <!-- Start UserName Field -->
                        <div class="form-group ed">
                            <label class="input-group-append" for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" autocomplete="off" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" required value="<?php echo $row[1] ?> ">

                        </div>
                        <!-- end UserName Field -->
                        <!-- Start Password  Field -->
                        <div class="form-group ed ">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="text" class="form-control" autocomplete="off" name="password" id="exampleInputPassword1" value="" placeholder="Leave it blank if you dont want to change password ">
                        </div>
                        <!-- end Password  Field -->
                        <div class="form-group ed ">
                            <label for="exampleInputPassword1">Email</label>
                            <input type="email" class="form-control" autocomplete="off" name="email" required id="exampleInputPassword1" value="<?php echo $row[4] ?>">
                        </div>
                        <div class="form-group ed ">
                            <label for="exampleInputPassword1">Full Name</label>
                            <input type="text" class="form-control" autocomplete="off" name="fullname" required id="exampleInputPassword1" value="<?php echo $row[3] ?>">
                        </div>
                        <div class="form-group ed ">
                            <input type="submit" class="btn btn-primary edbtn " autocomplete="off" autocomplete="new-password" value="Save">
                        </div>


                    </form>
                    <div class=" col-sm eimg"></div>
                </div>

            </div>
            <?php
            $stmt = $con->prepare("SELECT comments.* , users.UserName , items.ItemName FROM comments
                                                                                                      INNER JOIN users ON users.UserID = comments.user_id
                                                                                                      INNER JOIN items ON items.ItemID = comments.item_id
                                                                                                      where users.UserID=?");

            $stmt->execute(array($userid));
            $row2 = $stmt->fetchAll();



            ?>

            <div class="container manc">
                <h3 class="text-center"> <?php echo $row[1] ?> comments manage</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Item name</th>
                            <th scope="col">user name</th>
                            <th scope="col">Added Date</th>
                            <th scope="col">control</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($row2 as $v) {
                            echo "<tr>";
                            echo "<th  scope='col'>";
                            echo $v['Comment_ID'];
                            echo "</th>";
                            echo "<td  scope='col'>";
                            echo $v['Comment'];
                            echo "</td>";
                            echo "<td  scope='col'>";
                            echo $v['ItemName'];
                            echo "</td>";
                            echo "<td  scope='col'>";
                            echo $v['UserName'];
                            echo "</td>";
                            echo "<td  scope='col'>";
                            echo $v['Com_Date'];
                            echo "</td>";
                        ?>
                            <td>

                                <a type="button" class="btn tre confirm " href="<?php echo "comments.php?do=delete&commentid=" . $v['Comment_ID']  ?>"><i class="fas fa-comment-slash"></i> Delete</a>
                                <?php
                                if ($v['Status'] == 0) {
                                ?>
                                    <a type="button" class="btn tac" href="<?php echo "comments.php?do=approve&commentid=" . $v['Comment_ID']  ?>"><i class="fas fa-check"></i>approve</a>
                                <?php
                                }
                                ?>
                            </td>
                        <?php
                            echo "</tr>";
                        }

                        ?>

                    </tbody>
                </table>

            </div>
            <?php  
       
         } else {
        ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">Not Allwed</p>
            <?php
            header("refresh:5;url=logout.php");
        }
        
    }
    //====================
    //===end edit
    //====================

    //----------------------------------------------------------------------

    //====================
    //===start update
    //====================
    elseif ($do == "update") {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username =  str_replace(' ', '', $_POST['username']);;
            $password = '';
            $email    = $_POST['email'];
            $fullname = $_POST['fullname'];
            $userid = $_POST['userid'];

            $stmt = $con->prepare("select *  From users WHERE UserName=?");
            $stmt->execute(array($username));
            $row = $stmt->rowCount();
            // password edit
            if ($_POST['password'] == '') {
                $password = $_SESSION["password"];
            } else {
                $password = sha1($_POST['password']);
            }
            //  end password edit

            // start form error
            $formerror = array();
            if ($username == '') {
                $formerror[] = "you have to fill the Username";
            }
            if (strlen($username) < 4 || strlen($username) > 20) {
                $formerror[] = "The username have to be less than 20 char and more than 4";
            }
            if ($email == '') {
                $formerror[] = "you have to fill the Email";
            }
            if ($fullname == '') {
                $formerror[] = "you have to fill the Fullname";
            }


            if (count($formerror) == 0) {

                try {
                    $stmt = $con->prepare("Update users set UserName =? , Email =? , FullName=? , Password =? WHERE UserID=?");
                    $stmt->execute(array($username, $email, $fullname, $password, $userid));
            ?>
                    <div class="container updiv ">
                        <i class="fas fa-thumbs-up"></i>
                        <?php echo "<div >success</div>"; ?>
                    </div>
                <?php
                    header("refresh:5;url=?do=Edit&userid=$_SESSION[ID]");
                } catch (Exception $e) {
                ?>
                    <div class="container updiv ">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>not success try author user name</div>
                    </div>

                <?php
                    //error
                    header("refresh:5;url=?do=Edit&userid=$_SESSION[ID]");
                    //errpr
                }
            } else {


                ?>
                <div class="container updiv ">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php foreach ($formerror as $v) {
                        echo "<div>" . $v . "</div>";
                    }
                    header("refresh:5;url=?do=Edit&userid=$_SESSION[ID]");
                    ?>
                </div>

            <?php
            }
        } else {
            ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">Not allwed</p>
        <?php
            header("refresh:5;url=logout.php");
        }
    }


    //====================
    //===end update
    //====================

    //-------------------------------------------------------------------------

    //====================
    //===start ADD
    //====================
    elseif ($do == 'add') {

        ?>
        <div class="container">
            <h2 class="d-flex justify-content-start edh">Add New Member</h2>
        </div>

        <div class="container edcon">
            <div class="row">
                <form class="col-sm" action="?do=insert" method="POST" enctype="multipart/form-data"> 
                    <!-- Start UserName Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" autocomplete="off" name="username" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder="User Name To Login">

                    </div>
                    <!-- end UserName Field -->
                    <!-- Start Password  Field -->
                    <div class="form-group  ed ">

                        <label>Password</label>
                        <i class="fas fa-eye "></i>
                        <input type="password" class="form-control sh" autocomplete="off" name="password" required id="exampleInputPassword1" value="" placeholder="Your Password">

                    </div>
                    <!-- end Password  Field -->
                    <div class="form-group ed ">
                        <label>Email</label>
                        <input type="email" class="form-control" autocomplete="off" name="email" required id="exampleInputPassword1" placeholder=" Your Email">
                    </div>
                    <div class="form-group ed ">
                        <label>Full Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="fullname" required id="exampleInputPassword1" value="" placeholder="Your Full Name">
                    </div>
                    <div class="form-group ed ">
                        <label>Your Img</label>
                        <input type="file" class="form-control" autocomplete="off" name="avatar"  id="exampleInputPassword1" value="" placeholder="Your img">
                    </div>
                    <div class="form-group ed ">
                        <input type="submit" class="btn btn-primary edbtn" value="Add">
                    </div>


                </form>
                <div class=" col-sm adimg"></div>
            </div>

        </div>
        <?php
    }

    //====================
    //=== end add
    //====================

    //-------------------------------------------------------------------------


    //====================
    //=== start insert
    //====================

    elseif ($do == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //flie uplode

            $avatar = $_FILES['avatar'];
            $avatarname = $avatar['name'];
            $avatartype = $avatar['type'];
            $avatarsize = $avatar['size'];
            $avatartemp = $avatar['tmp_name'];
            $allowavatarextantion = array("jpeg","jpg","png","gif");
           

            $avatarextantion = explode(".",$avatarname);
            $avatarextantion = strtolower( end($avatarextantion));
           
           
           
       


            $username =  str_replace(' ', '', $_POST['username']);
            $password = sha1(str_replace(' ', '', $_POST['password']));
            $email    = str_replace(' ', '', $_POST['email']);
            $fullname = $_POST['fullname'];
            $userid = $_SESSION["ID"];


            $stmt = $con->prepare("select *  From users WHERE UserName=?");
            $stmt->execute(array($username));
            $row = $stmt->rowCount();

            // start form error
            $formerror = array();
            if ($username == '') {
                $formerror[] = "you have to fill the Username";
            }
            if (strlen($username) < 4 || strlen($username) > 20) {
                $formerror[] = "The username have to be less than 20 char and more than 4";
            }
            if ($email == '') {
                $formerror[] = "you have to fill the Email";
            }
            if ($_POST['password'] == '') {
                $formerror[] = "you have to fill the Password";
            }
            if ($fullname == '') {
                $formerror[] = "you have to fill the Fullname";
            }

            if ($row > 0) {
                $formerror[] = "This username is allredy used";
            }
            if(  !in_array($avatarextantion,$allowavatarextantion) &&!empty($avatartemp) ){
                $formerror[] = "this extinsion is not allwed";

            }
            if ($avatarsize>2000000) {
                $formerror[] = "This img is not allwed big size";
            }
         

            if (count($formerror) == 0) {
                if ( !empty($avatartemp)) {

                    rand(0,100000);
                    $avatarimg =  rand(0,1000000000) . "_" . $avatarname;
                    move_uploaded_file($avatartemp,"uploads\avatar\\".$avatarimg);
                }
                else{
                    $avatarimg="defult.png";
                    
                }
              
               
                    $stmt = $con->prepare("INSERT INTO `users` ( `UserName`,`avatar`, `Password`, `FullName`, `Email` ,RegesterDate ,RegStatus) VALUES (?,?,?,?,?,now(),1)");
                    $stmt->execute(array($username,$avatarimg, $password, $fullname, $email));
                ?>
                <div class="container updiv ">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo "<div >success</div>"; ?>
                </div>
            <?php
                //  header("refresh:5;url=?do=add");
            } else {


            ?>
                <div class="container updiv ">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php foreach ($formerror as $v) {
                        echo "<div>" . $v . "</div>";
                    }
                    header("refresh:5;url=?do=add");
                    ?>
                </div>

            <?php
            }
        } else {
            ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">not allwed </p>
            <?php
            header("refresh:5;url=logout.php");
        }
    }
    //====================
    //=== end insert
    //==================== 



    //----------------------------------------------


    //====================
    //=== start delet
    //==================== 
    elseif ($do == 'delete') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : -1;
        try {

            $stmt = $con->prepare("SELECT * FROM `users` WHERE   UserID=?  LIMIt 1 ");
            $stmt->execute(array($userid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
        } catch (Exception $e) {
            echo $e;
        }
        if ($_GET['userid'] == $_SESSION['ID'] || ($count > 0 && ($row['GroupID'] != 1))) {
            try {

                $stmt = $con->prepare("DELETE FROM users WHere UserID=?");
                $stmt->execute(array($userid));
            ?>
                <div class="container updiv ">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo "<div >success</div>"; ?>
                </div>
            <?php
                header("refresh:5;url=?do=manage");
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">not allwed</p>
        <?php
            header("refresh:5;url=dashboard.php");
        }
        if ($_GET['userid'] == $_SESSION['ID']) {
        ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">you delete your acount</p>
        <?php
            header("location:logout");
            exit();
        }
    }

    //----------------------------------------------
    //====================
    //=== end delet;
    //==================== 



    //----------------------------------------------
    //====================
    //=== Start Activate
    //==================== 

    elseif ($do == 'Activate') {
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : -1;
       
        try {

            $stmt = $con->prepare("UPDATE users  set RegStatus =1 where userid =".$userid);
            $stmt->execute();
        ?>
            <div class="container updiv ">
                <i class="fas fa-thumbs-up"></i>
                <?php echo "<div >success</div>"; ?>
            </div>
        <?php
            header("refresh:5;url=?do=manage");
        } catch (Exception $e) {
            ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">not allwed</p>
    
    <?php
        }
    } 



    // this else used when do = non of above valus
    else {
        ?>
        <i class="fas fa-dog dog d-flex justify-content-center"></i>
        <p class="dogp  d-flex justify-content-center">not allwed</p>

<?php
        header("refresh:5;url=dashboard.php");
    
    }



    include "Inclodes/templates/footer.php";
}
//this else used when there is no username sission
else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>