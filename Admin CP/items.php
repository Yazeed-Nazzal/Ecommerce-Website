<?php
ob_start();
session_start();
$pagetitle = 'items';
if (isset($_SESSION['username'])) {
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    // rename the title
    if ($do == 'Edit') {
        $pagetitle = "edit";
    } elseif ($do == 'update') {
        $pagetitle = "update";
    } elseif ($do == 'add') {
        $pagetitle = "add";
    } elseif ($do == 'insert') {
        $pagetitle = "insert";
    } elseif ($do == 'delete') {
        $pagetitle = "delete";
    } elseif ($do == 'manage') {
        $pagetitle = "items";
    }
    // rename the title
    include "init.php";

    //================================
    //======== manage start
    //================================

    if ($do == 'manage') {
        $stmt = $con->prepare("SELECT  items.* , categories.CatName , categories.CatID, users.UserName ,users.UserID from items INNER JOIN categories on categories.CatID = items.Cat_ID INNER JOIN users on users.UserID=items.User_ID ");
        $stmt->execute();
        $rows = $stmt->fetchAll();


?>

        <div class="container manc">
            <h3 class="text-center">manage items</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Date</th>
                        <th scope="col">Categories</th>
                        <th scope="col">UserName</th>
                        <th scope="col">control</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<th  scope='col'>";
                        echo $row['ItemID'];
                        echo "</th>";
                        echo "<td  scope='col'>";
                        echo $row['ItemName'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['Description'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['Price'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['Date'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['CatName'];
                        echo "</td>";
                        echo "<td  scope='col'>";
                        echo $row['UserName'];
                        echo "</td>";
                    ?>
                        <td scope='col'>
                            <a type="button" class="btn ted" href="<?php echo "?do=Edit&itemid=" . $row['ItemID'] . "&UserID=" . $row['UserID'] . "&catid=" . $row['CatID'] ?>"><i class="fas fa-edit"></i>Edit </a>
                            <a type="button" class="btn tre confirm " href="<?php echo "?do=delete&itemid=" . $row['ItemID'] ?>"> <i class="fas fa-user-times"></i>Delete </a>
                            <?php
                            if ($row['approve'] == 0) {
                            ?>

                                <a type="button" class="btn tac" href="?do=approve&itemid=<?php echo $row['ItemID'] ?>"><i class="fas fa-check"></i>Approve</a>
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
            <a class="btn tre" href="?do=add"><i class="fas fa-user-plus"></i>Add new Item </a>
        </div>

        <?php

    }
    //================================
    //======== manage end
    //================================
    //------------------------------------------------------------------------------
    //================================
    //======== Edit Strat
    //================================
    elseif ($do == 'Edit') {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : -1;



        try {

            $stmt = $con->prepare("SELECT * FROM `items` WHERE ItemID=?  LIMIt 1 ");
            $stmt->execute(array($itemid));
            $row = $stmt->fetchAll();
            $count = $stmt->rowCount();
        } catch (Exception $e) {
        }

        if ($count > 0) {
        ?>
            <div class="container">
                <h2 class="d-flex justify-content-start edh">Edit Item</h2>
            </div>

            <div class="container edcon">
                <div class="row">
                    <form class="col-sm" action="?do=update" method="POST">
                        <!-- Start Name Field -->
                        <div class="form-group ed">
                            <label class="input-group-append" for="exampleInputEmail1">Item name</label>
                            <input type="text" class="form-control" require autocomplete="off" name="name" value="<?php echo $row[0]['ItemName'] ?>" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Name Of The Item ">

                        </div>
                        <div class="form-group ed">
                            <label class="input-group-append" for="exampleInputEmail1">Item name</label>
                            <input type="hidden" name="itemId" value="<?php echo $row[0]['ItemID'] ?>" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Name Of The Item ">

                        </div>
                        <!-- end Name Field -->
                        <!-- Start Description Field -->
                        <div class="form-group ed">
                            <label class="input-group-append" for="exampleInputEmail1">Description</label>
                            <input type="text" class="form-control" require autocomplete="off" name="Description" value="<?php echo $row[0]['Description']; ?>" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Description Of The Item ">

                        </div>
                        <!-- end Description Field -->
                        <!-- start Price Field -->
                        <div class="form-group ed">
                            <label class="input-group-append" for="exampleInputEmail1">Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" require autocomplete="off" name="Price" value="<?php echo $row[0]['Price']; ?>" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Price Of The Item ">

                        </div>
                        <!-- end Price Field -->
                        <!-- start MadeCountry Field -->
                        <div class="form-group ed">
                            <label class="input-group-append" for="exampleInputEmail1">Country&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" require autocomplete="off" name="Country" value="<?php echo $row[0]['MadeCountry']; ?>" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" MadeCountry Of The Item ">

                        </div>
                        <!-- end MadeCountry Field -->
                        <!-- Start State Field -->
                        <div class="form-group ed">
                            <label for="inputState">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select id="inputState" name="status" class="form-control selectpicker">
                                <option <?php if ($row[0]['Status'] == 0) {
                                            echo "selected";
                                        } ?> value="0" selected>Choose...</option>
                                <option <?php if ($row[0]['Status'] == 1) {
                                            echo "selected";
                                        } ?> value="1">New</option>
                                <option <?php if ($row[0]['Status'] == 2) {
                                            echo "selected";
                                        } ?> value="2">Like New</option>
                                <option <?php if ($row[0]['Status'] == 3) {
                                            echo "selected";
                                        } ?> value="3">Used</option>
                                <option <?php if ($row[0]['Status'] == 4) {
                                            echo "selected";
                                        } ?> value="4">Very Old</option>

                            </select>
                        </div>
                        <!-- end State Field -->
                        <!-- Start rating Field -->
                        <div class="form-group ed">
                            <label for="inputState">Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select id="inputState" name="rate" class="form-control ">
                                <option <?php if ($row[0]['Rating'] == 0) {
                                            echo "selected";
                                        } ?> value="0" selected>Choose...</option>
                                <option <?php if ($row[0]['Rating'] == 1) {
                                            echo "selected";
                                        } ?> value="1">1</option>
                                <option <?php if ($row[0]['Rating'] == 2) {
                                            echo "selected";
                                        } ?> value="2">2</option>
                                <option <?php if ($row[0]['Rating'] == 3) {
                                            echo "selected";
                                        } ?> value="3">3</option>
                                <option <?php if ($row[0]['Rating'] == 4) {
                                            echo "selected";
                                        } ?> value="4">4</option>
                                <option <?php if ($row[0]['Rating'] == 5) {
                                            echo "selected";
                                        } ?> value="5">5</option>

                            </select>
                        </div>
                        <!-- end rating Field -->
                        <!-- start users Field -->
                        <div class="form-group ed">
                            <label for="inputState">Users&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <?php
                            $stmt = $con->prepare("SELECT * from users ");
                            $stmt->execute();
                            $row3 = $stmt->fetchAll();
                            ?>
                            <select id="inputState" name="user" class="form-control ">
                                <option value="-1" selected>Choose...</option>
                                <?php
                                foreach ($row3 as $v) {
                                    if ($_GET['UserID'] == $v['UserID']) {
                                        echo "<option selected  value='" . $v['UserID'] . "'>" . $v['UserName'] . "</option>";
                                    } else {
                                        echo "<option  value='" . $v['UserID'] . "'>" . $v['UserName'] . "</option>";
                                    }
                                }

                                ?>

                            </select>
                        </div>
                        <!-- start users Field -->
                        <!-- start cat Field -->
                        <div class="form-group ed">
                            <label for="inputState">Categories</label>
                            <select id="inputState" name="cat" class="form-control ">
                                <?php
                                $stmt = $con->prepare("SELECT * from categories");
                                $stmt->execute();
                                $row4 = $stmt->fetchAll();
                                ?>
                                <option value="-1" selected>Choose...</option>
                                <?php
                                foreach ($row4 as $v) {
                                    if ($_GET['catid'] == $v['CatID']) {
                                        echo "<option  selected value='" . $v['CatID'] . "'>" . $v['CatName'] . "</option>";
                                    } else {
                                        echo "<option  value='" . $v['CatID'] . "'>" . $v['CatName'] . "</option>";
                                    }
                                }

                                ?>

                            </select>
                        </div>
                        <!-- end cat Field -->
                        <div class="form-group ed ">
                              <label>Your Img</label>
                              <input type="file" class="form-control" autocomplete="off" name="avatar"  id="exampleInputPassword1" value="" placeholder="Your img">
                        </div>





                        <div class="form-group ed ">
                            <input type="submit" class="btn btn-primary edbtn" value="Add">
                        </div>


                    </form>
                    <div class=" col-sm eimg"></div>
                </div>

            </div>
            <?php
            $stmt = $con->prepare("SELECT comments.* , users.UserName , items.ItemName FROM comments
                                                                                                      INNER JOIN users ON users.UserID = comments.user_id
                                                                                                      INNER JOIN items ON items.ItemID = comments.item_id
                                                                                                      where items.ItemID =?");

            $stmt->execute(array($itemid));
            $row2 = $stmt->fetchAll();



            ?>

            <div class="container manc">
                <h3 class="text-center"> <?php echo $row[0]['ItemName'] ?> comments manage</h3>
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


        }
    }
    //================================
    //======== Edit end
    //================================
    //------------------------------------------------------------------------------------------------
    elseif ($do == 'update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $itemid     = $_POST['itemId'];
            $itemname   = $_POST['name'];
            $itemdes    = $_POST['Description'];
            $Price      = str_replace(" ", "", $_POST['Price']);
            $Country    = $_POST['Country'];
            $status     = str_replace(" ", "", $_POST['status']);
            $rate       = str_replace(" ", "", $_POST['rate']);
            $usaerid    = str_replace(" ", "", $_POST['user']);
            $cat        = str_replace(" ", "", $_POST['cat']);

            $formerror = array();
            if ($itemname == '') {
                $formerror[] = "you have to fill the item name";
            }
            if ($itemdes == '') {
                $formerror[] = "you have to fill the item Description";
            }
            if ($Price == '') {
                $formerror[] = "you have to fill the price item";
            }
            if (!is_numeric($Price)) {
                $formerror[] = "you have to fill the price with Number";
            }
            if ($Country == '') {
                $formerror[] = "you have to fill the Country item";
            }
            if ($status == 0) {
                $formerror[] = "you have to choose the status of the item ";
            }
            if ($rate == 0) {
                $formerror[] = "you have to choose the rating of the item ";
            }
            if ($usaerid == -1) {
                $formerror[] = "you have to choose the user of the item ";
            }
            if ($cat == -1) {
                $formerror[] = "you have to choose the Cat of the item ";
            }

            if (count($formerror) > 0) {
                foreach ($formerror as $v) {
            ?>
                    <div class="container updiv ">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php
                            echo "<div>" . $v . "</div>";
                        
                        header("refresh:5;url=?do=add");
                        ?>
                    </div>
                <?php
                }
            } else {
                try {
                    $stmt = $con->prepare("UPDATE items set 
                                                        ItemName=? , `Description`=?, Price=?, MadeCountry =?,
                                                        Status =?, Rating =?	 , Cat_ID= ? , `User_ID`= ? where ItemID =?");
                    $stmt->execute(array($itemname, $itemdes, $Price, $Country, $status, $rate, $cat, $usaerid, $itemid));
                ?>
                    <div class="container updiv ">
                        <i class="fas fa-thumbs-up"></i>
                        <?php echo "<div >success</div>"; ?>
                    </div>
                <?php
                    header("refresh:5;url=?do=add");
                } catch (Exception $e) {
                ?>
                    <div class="container updiv ">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>not success</div>
                    </div>

        <?php
                    //error
                    header("refresh:5;url=?do=Edit&userid=$_SESSION[ID]");
                    //errpr
                }
            }
        }
    }

    //-------------------------------------------------------------
    //============================
    //====== start ADD
    //============================
    elseif ($do == 'add') {

        ?>
        <div class="container">
            <h2 class="d-flex justify-content-start edh">Add New Item</h2>
        </div>

        <div class="container edcon">
            <div class="row">
                <form class="col-sm" action="?do=insert" method="POST">
                    <!-- Start Name Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" require autocomplete="off" name="name" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Name Of The Item ">

                    </div>
                    <!-- end Name Field -->
                    <!-- Start Description Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Description</label>
                        <input type="text" class="form-control" require autocomplete="off" name="Description" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Description Of The Item ">

                    </div>
                    <!-- end Description Field -->
                    <!-- start Price Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" class="form-control" require autocomplete="off" name="Price" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Price Of The Item ">

                    </div>
                     <!-- end Price Field -->
                
                   
                    <!-- start MadeCountry Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Country&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" class="form-control" require autocomplete="off" name="Country" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" MadeCountry Of The Item ">

                    </div>
                    <!-- end MadeCountry Field -->
               
                    <!-- Start State Field -->
                    <div class="form-group ed">
                        <label for="inputState">State&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select id="inputState" name="status" class="form-control selectpicker">
                            <option value="0" selected>Choose...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>

                        </select>
                    </div>
                    <!-- end State Field -->
                    <!-- Start rating Field -->
                    <div class="form-group ed">
                        <label for="inputState">Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select id="inputState" name="rate" class="form-control ">
                            <option value="0" selected>Choose...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>
                    </div>
                    <!-- end rating Field -->
                    <!-- start users Field -->
                    <div class="form-group ed">
                        <label for="inputState">Users&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select id="inputState" name="user" class="form-control ">
                            <option value="-1" selected>Choose...</option>
                            <?php
                            $stmt = $con->prepare("SELECT * from users ");
                            $stmt->execute();
                            $row = $stmt->fetchAll();
                            print_r($row);
                            foreach ($row as $v) {

                                echo "<option  value='" . $v['UserID'] . "'>" . $v['UserName'] . "</option>";
                            }

                            ?>

                        </select>
                    </div>
                    <!-- start users Field -->
                    <!-- start cat Field -->
                    <div class="form-group ed">
                        <label for="inputState">Categories</label>
                        <select id="inputState" name="cat" class="form-control ">
                            <option value="-1" selected>Choose...</option>
                            <?php
                            $stmt = $con->prepare("SELECT*  from categories where parent = 0");
                            $stmt->execute();
                            $row = $stmt->fetchAll();
                            print_r($row);
                            foreach ($row as $v) {

                                echo "<option  value='" . $v['CatID'] . "'>" . $v['CatName'] . "</option>";
                                $stmt2 = $con->prepare("SELECT *  from categories WHERE parent=".$v['CatID']);
                                $stmt2->execute();
                                $row2 = $stmt2->fetchAll();

                                foreach($row2 as $v2){
                                    echo "<option  value='" . $v2['CatID'] . "'>---" . $v2['CatName'] . "</option>";
                                }
                            }

                            ?>

                        </select>
                    </div>
                    <!-- end cat Field -->





                    <div class="form-group ed ">
                        <input type="submit" class="btn btn-primary edbtn" value="Add">
                    </div>


                </form>
                <div class=" col-sm adimg"></div>
            </div>

        </div>
        <?php

    }
    //============================
    //====== end ADD
    //============================
    //--------------------------------------------------------------
    //============================
    //======  start insert
    //============================
    elseif ($do == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $itemname   = $_POST['name'];
            $itemdes    = $_POST['Description'];
            $Price      = str_replace(" ", "", $_POST['Price']);
            $Country    = $_POST['Country'];
            $status     = str_replace(" ", "", $_POST['status']);
            $rate       = str_replace(" ", "", $_POST['rate']);
            $usaerid    = str_replace(" ", "", $_POST['user']);
            $cat        = str_replace(" ", "", $_POST['cat']);

            $formerror = array();
            if ($itemname == '') {
                $formerror[] = "you have to fill the item name";
            }
            if ($itemdes == '') {
                $formerror[] = "you have to fill the item Description";
            }
            if ($Price == '') {
                $formerror[] = "you have to fill the price item";
            }
            if (!is_numeric($Price)) {
                $formerror[] = "you have to fill the price with Number";
            }
            if ($Country == '') {
                $formerror[] = "you have to fill the Country item";
            }
            if ($status == 0) {
                $formerror[] = "you have to choose the status of the item ";
            }
            if ($rate == 0) {
                $formerror[] = "you have to choose the rating of the item ";
            }
            if ($usaerid == -1) {
                $formerror[] = "you have to choose the user of the item ";
            }
            if ($cat == -1) {
                $formerror[] = "you have to choose the Cat of the item ";
            }

            if (count($formerror) > 0) {
                foreach ($formerror as $v) {
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
                try {
                    $stmt = $con->prepare("INSERT INTO `items` (`ItemName`,`Description`,`Price`,`Date`,`MadeCountry`,`Status`,`Rating`,`Cat_ID` ,`User_ID`) VALUES (?,?,?,now(),?,?,?,?,?)");
                    $stmt->execute(array($itemname, $itemdes, $Price, $Country, $status, $rate, $cat, $usaerid));
                } catch (Exception $e) {
                    echo $e;
                }
                ?>
                <div class="container updiv ">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo "<div >success</div>"; ?>
                </div>
            <?php
                header("refresh:5;url=?do=add");
            }
        }
    }
    //============================
    //======  end insert
    //============================


    //----------------------------------------------------------------------------------------------------

    //============================
    //======  Start Delete
    //============================
    elseif ($do == 'delete') {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : -1;
        try {

            $stmt = $con->prepare("SELECT * FROM `items` WHERE   ItemID=?  LIMIt 1 ");
            $stmt->execute(array($itemid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) {
                $stmt = $con->prepare("DELETE FROM items WHere ItemID=?");
                $stmt->execute(array($itemid));
            ?>
                <div class="container updiv ">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo "<div >success</div>"; ?>
                </div>
            <?php
                header("refresh:5;url=items.php");
            } else {
            ?>
                <div class="container updiv ">
                    <i class="fas fa-dog dog d-flex justify-content-center"></i>
                    <p class="dogp  d-flex justify-content-center">not allwed</p>
                </div>

            <?php
                //error
                header("refresh:5;url=items.php");
                //errpr

            }
        } catch (Exception $e) {
            ?>
            <div class="container updiv ">
                <i class="fas fa-exclamation-triangle"></i>
                <div>not success</div>
            </div>

        <?php
            //error
            header("refresh:5;url=items.php");
            //errpr

        }
    }

    //----------------------------------------------------------------------------------------------------

    //============================
    //======  end Delete
    //============================

    //-------------------------------------------------------------------------------------------------------



    //============================
    //======  Start Approve
    //============================

    elseif ($do == 'approve') {
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : -1;
        try {

            $stmt = $con->prepare("UPDATE items  set approve =1 where ItemID =" . $itemid);
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
            header("refresh:5;url=?do=manage");
        }
    } else {
    }
    include "Inclodes/templates/footer.php";
}


ob_end_flush();
?>