<?php
ob_start();
session_start();
$pagetitle='Catecories';
if (isset($_SESSION['username'])) {
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage'; 
// rename the title
    if ($do == 'Categories') {
        $pagetitle = "Categories";
    }elseif ($do == 'Edit') {
        $pagetitle = "edit";
    } elseif ($do == 'update') {
        $pagetitle = "update";
    } elseif ($do == 'add') {
        $pagetitle = "add";
    } elseif ($do == 'insert') {
        $pagetitle = "insert";
    } elseif ($do == 'delete') {
        $pagetitle = "delete";
    }elseif ($do == 'manage') {
        $pagetitle = "manage";
    } else {
        $pagetitle = "error";
    }
    
 // end rename the title 
    include "init.php";
    //====================
    //===sratr manage
    //====================
    if ($do == 'manage') {

        $sort = " ASC";
        if (isset($_GET["sort"]) && $_GET["sort"] == 'DESC') {
            $sort = "DESC";
            
        }
        else {
            $sort = " ASC";
        }
        $stmt = $con->prepare("SELECT * FROM categories WHERE parent =0 ORDER by Ordaring  " . $sort);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>
        <div class="container">
                <h3 class="text-center cath3">manage categories</h3>
                <div class="card">
                        <div class="card-header">
                            <p>categories</p>
                            <div  class="float-right pull-right" >
                                   <span class =""><i class="fas fa-sort"></i> ordarby : </span>
                                    <a class = " A <?php  if(isset($_GET['sort']) && $_GET['sort'] == 'ASC') {echo 'Active';} ?>" href="?sort=ASC">ASC </a> |
                                    <a class = " A <?php  if(isset($_GET['sort']) && $_GET['sort'] == 'DESC') {echo 'Active';} ?>" href="?sort=DESC">DESC</a>
                                    
                            </div>
                            <div  class="float-right pull-right" >
                            <span class =""><i style="color: #fff" class="fas fa-eye"></i> view : </span>
                                <span class="full A">full</span>|
                                 <span class="classic A">classic</span>

                            </div>
                        </div>
                        <div class="card-body">
                            <?php 
                              foreach($rows as $val)
                              {
                                ?>
                                     <div class ='cat'>
                                     <h3 > <?php echo $val['CatName'] ?></h3>
                                     <p><?php  echo $val['Description'] ?></p>
                                     <div class = acont>
                                     <a type="button" class="btn float-right pull-right debt cata" href="?do=Edit&catid=<?php echo $val['CatID'] ?>"> <i class="fas fa-edit"></i>Edit</a>
                                     <a type="button" class="btn float-right pull-right debt cata"  href="?do=delete&catid=<?php echo $val['CatID'] ?>"> <i class="fas fa-trash-alt"></i>Delete</a>
                                     </div>
                              
                                     <?php
                                if ($val['visibility']==0) {
                                    echo "<span class ='vis'> hidden</span>";
                                }
                                if ($val['Allow_Comment']==0) {
                                    echo "<span class ='vis'> Comment Not Allowed </span>";
                                }
                                if ($val['Allow_Ads']==0) {
                                    echo "<span class ='vis'> ADS Not Allowed </span>";
                                }
                                ?>
                                <h4>sub categories</h4>
                                <ul>
                                <?php
                                $cats = getcat("WHERE parent=".$val['CatID']);
                                foreach ($cats as $v){
                                     ?>
                                       <li class="link-child">
                                           <a class="subcat" href="?do=Edit&catid=<?php echo $v['CatID'] ?>"><?php echo $v['CatName'] ?></a>
                                           <a type="button" class="show-delete"  href="?do=delete&catid=<?php echo $v['CatID'] ?>"> <i class="fas fa-trash-alt"></i>Delete</a>
                                    </li>
                                     <?php
                                }
                              
                                echo "</div>";
                                
                             
                      
                              }
                            

                        ?>
                                 </ul>
                            </div>
                           
                        </div>
                        <a class="btn tre catmb" href="?do=add"><i class="fas fa-user-plus"></i>Add New Categories </a> 
                </div>
               
               
       


        <?php
   
    }
    //====================
    //===end manage
    //====================
    //------------------------------------------------------------------

    //====================
    //===sratr edit
    //====================    
     elseif ($do == 'Edit' && isset($_GET['catid'])) {
         
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : -1;


        // get the data from data base
        try {

            $stmt = $con->prepare("SELECT * FROM `categories` WHERE CatID = ?  LIMIt 1 ");
            $stmt->execute(array($catid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
        } catch (Exception $e) {
            echo $e;
        }
        if ($count>0) {
            # code...
        
        ?>
        <div class="container">
            <h2 class="d-flex justify-content-start edh">Edit Catecories</h2>
        </div>

        <div class="container edcon">
            <div class="row">
                <form class="col-sm" action="?do=update" method="POST">
                    <!-- Start Name Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" value="<?php echo $row["CatName"] ?>" id="exampleInputEmail1" aria-describedby="emailHelp" >
 <input type="hidden" class="form-control" autocomplete="off" name="CatID" value="<?php echo $row["CatID"] ?>" id="exampleInputEmail1" aria-describedby="emailHelp" >
                    </div>
                    <!-- end Name Field -->
                    <!-- Start Description  Field -->
                    <div class="form-group  ed ">

                        <label>Description</label>
                        <input type="text" class="form-control sh" autocomplete="off" name="description" id="exampleInputPassword1" value="<?php echo $row["Description"] ?>">

                    </div>
                    <!-- end Description  Field -->
                    <!-- start ordaring Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Ordaring</label>
                        <input type="text" class="form-control" autocomplete="off" name="ordaring" value="<?php echo $row["Ordaring"] ?>" id="exampleInputEmail1" aria-describedby="emailHelp" ">

                    </div>
                    <!-- end ordaring Field -->
                    <!-- Start visibilty -->
                    <div class="form-group chf ">
                            <label class="form-check-label" for="inlineRadio2">Visibilty</label>
                            <div class="form-check form-check-inline ch  ">
                                    
                                    <input class="form-check-input  " <?php  if($row['visibility']==1){echo 'checked';} ?>  type="radio" name="visibilty"  id="inlineRadio1" value="1">
                                    <label class="form-check-label"  for="inlineRadio1">true</label>
                            </div>
                            <div class="form-check form-check-inline ch ">
                                        
                                        <input class="form-check-input " type="radio" name="visibilty" <?php  if($row['visibility']==0){echo 'checked';} ?>   id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">false</label>
                            </div>
                    </div>
                     <!-- end visibilty -->
                     <!-- Start comment-->
                    <div class="form-group chf  ">
                            <label class="form-check-label" for="inlineRadio2">Comment</label>
                            <div class="form-check form-check-inline ch ">
                                    <input class="form-check-input " checked type="radio" <?php  if($row['Allow_Comment']==1){echo 'checked';} ?> name="comment" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">true</label>
                            </div>
                            <div class="form-check form-check-inline ch">
                                        
                                        <input class="form-check-input" type="radio" <?php  if($row['Allow_Comment']==0){echo 'checked';} ?>  name="comment" id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">false</label>
                            </div>
                           
                    </div>
                    <!-- end comment-->
                    <!-- Start ADS-->
                    <div class="form-group chf  ">
                            <label class="form-check-label" for="inlineRadio2"> ADS</label>
                            <div class="form-check form-check-inline ch ">
                                    <input class="form-check-input " checked type="radio"  <?php  if($row['Allow_Ads']==1){echo 'checked';} ?> name="ads" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">true</label>
                            </div>
                            <div class="form-check form-check-inline ch">
                                        
                                        <input class="form-check-input" type="radio" <?php  if($row['Allow_Ads']==0){echo 'checked';} ?> name="ads" id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">false</label>
                            </div>
                           
                    </div>
                    <!-- end ADS-->
                             <!-- start parent  -->
                             <div class="form-group ed">
                            <label for="inputState">parent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select id="inputState" name="cat" class="form-control  ">
                                <option value="0" selected>non</option>
                                <?php
                                $rows = getall('categories','CatName' ,"ASC","WHERE parent = 0");
                                foreach ($rows as $v) {
                                    if ($row['parent']==$v['CatID']) {
                                        echo "<option selected   value='" . $v['CatID'] . "'>" . $v['CatName'] . "</option>";
                                        
                                    }
                                    else{
                                       
                                        echo "<option   value='" . $v['CatID'] . "'>" . $v['CatName'] . "</option>";
                                    }
                                   
                                }

                                ?>

                            </select>
                    </div>
                      <!-- end parent  -->
                   
                   
                    <div class="form-group ed ">
                                <input type="submit" class="btn btn-primary edbtn" value="Save">
                    </div>


                </form>
                <div class=" col-sm eimg"></div>
            </div>

        </div>

        <?php
        }
        else
        {
            ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">not allwed </p>
            <?php
            header("refresh:5;url=categories.php");
        }
    }
    //-----------------------------------------------------------------
    //====================
    //===sratr update
    //====================
     elseif ($do == 'update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $catid     =  str_replace(' ' , '' , $_POST['CatID']);
            $catname   =  $_POST['name'];
            $catdiscip =$_POST['description'];
            $order     = str_replace(' ','',$_POST['ordaring']);
            $vis       = str_replace(' ','',$_POST['visibilty']);
            $comment   = str_replace(' ','',$_POST['comment']);
            $ads       = str_replace(' ', '',$_POST['ads']);
            $cat       = $_POST['cat'];
            


            $stmt = $con->prepare("select *  From categories WHERE CatName=?");
            $stmt->execute(array($catname));
            $row = $stmt->fetchAll();
            $count= $stmt->rowCount();
            $formerror = array();

            if ($count > 0 && $row[0]['CatID'] != $catid) {
                $formerror[] = "This Name is Alrady Used";
                
                echo $catid;
            }
            if ( !is_numeric($order)) {
                $formerror[] = "Ordering must be number";
            }
            

            if (count($formerror) == 0) {
                try {
                $stmt = $con->prepare("Update categories set
                                                            CatName=? , Description =? , Ordaring=? ,
                                                            visibility=? , Allow_Comment=?,
                                                            Allow_Ads =?, parent =? WHERE CatID=?");
                                                           
                $stmt->execute(array($catname,$catdiscip,$order,$vis,$comment,$ads,$cat,$catid));
                ?>
                    <div class="container updiv ">
                        <i class="fas fa-thumbs-up"></i>
                        <?php echo "<div >success</div>"; ?>
                    </div>
               <?php
                header("refresh:5;url=?do=manage");
                }
                catch (Exception $e) {
                    ?>
                        <div class="container updiv ">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>not success </div>
                        </div>
    
                    <?php
                      header("refresh:5;url=?do=Edit&catid=$catid");
            }

        }
        else {
            ?>
                <div class="container updiv ">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php foreach ($formerror as $v) {
                        echo "<div>" . $v . "</div>";
                    }
                    header("refresh:5;url=?do=Edit&catid=$catid");
                    ?>
                </div>

            <?php
        }
        
        }
    }

    //====================
    //===end update
    //====================
    //----------------------------------------------------------------------
    //====================
    //===sratr ADD
    //====================
     elseif ($do == 'add') {
      
        ?>
        <div class="container">
            <h2 class="d-flex justify-content-start edh">Add New Catecories</h2>
        </div>

        <div class="container edcon">
            <div class="row">
                <form class="col-sm" action="?do=insert" method="POST">
                    <!-- Start Name Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="name" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Name Of Category ">

                    </div>
                    <!-- end Name Field -->
                    <!-- Start Description  Field -->
                    <div class="form-group  ed ">

                        <label>Description</label>
                        <input type="text" class="form-control sh" autocomplete="off" name="description" required id="exampleInputPassword1" value="" placeholder="Descripe The Category">

                    </div>
                    <!-- end Description  Field -->
                    <!-- start ordaring Field -->
                    <div class="form-group ed">
                        <label class="input-group-append" for="exampleInputEmail1">Ordaring</label>
                        <input type="text" class="form-control" autocomplete="off" name="ordaring" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Name Of Category ">

                    </div>
                    <!-- end ordaring Field -->
                    
                    <!-- Start visibilty -->
                    <div class="form-group chf ">
                            <label class="form-check-label" for="inlineRadio2">Visibilty</label>
                            <div class="form-check form-check-inline ch  ">
                                    <input class="form-check-input  " checked type="radio" name="visibilty"  id="inlineRadio1" value="1">
                                    <label class="form-check-label"  for="inlineRadio1">true</label>
                            </div>
                            <div class="form-check form-check-inline ch ">
                                        
                                        <input class="form-check-input " type="radio" name="visibilty"  id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">false</label>
                            </div>
                    </div>
                     <!-- end visibilty -->
                     <!-- Start comment-->
                    <div class="form-group chf  ">
                            <label class="form-check-label" for="inlineRadio2">Comment</label>
                            <div class="form-check form-check-inline ch ">
                                    <input class="form-check-input " checked type="radio" name="comment" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">true</label>
                            </div>
                            <div class="form-check form-check-inline ch">
                                        
                                        <input class="form-check-input" type="radio" name="comment" id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">false</label>
                            </div>
                           
                    </div>
                    <!-- end comment-->
                    <!-- Start ADS-->
                    <div class="form-group chf  ">
                            <label class="form-check-label" for="inlineRadio2"> ADS</label>
                            <div class="form-check form-check-inline ch ">
                                    <input class="form-check-input " checked type="radio" name="ads" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">true</label>
                            </div>
                            <div class="form-check form-check-inline ch">
                                        
                                        <input class="form-check-input" type="radio" name="ads" id="inlineRadio2" value="0">
                                        <label class="form-check-label" for="inlineRadio2">false</label>
                            </div>
                           
                    </div>
                    <!-- end ADS-->
                         <!-- start parent  -->
                         <div class="form-group ed">
                            <label for="inputState">parent&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select id="inputState" name="cat" class="form-control  ">
                                <option value="0" selected>non</option>
                                <?php
                                $row = getall('categories','CatName' ,"ASC","WHERE parent = 0");
                                foreach ($row as $v) {
                                    echo "<option  value='" . $v['CatID'] . "'>" . $v['CatName'] . "</option>";
                                }

                                ?>

                            </select>
                    </div>
                      <!-- end parent  -->
                   
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
    //===end ADD
    //====================
    //-----------------------------------------------------------------------
    //====================
    //===sratr insert
    //====================
     elseif ($do == 'insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $catname =  $_POST['name'];
            $catdiscip = $_POST['description'];
            $order = str_replace(' ','',$_POST['ordaring']);
            $vis = str_replace(' ','',$_POST['visibilty']);
            $comment = str_replace(' ','',$_POST['comment']);
            $ads = str_replace(' ', '',$_POST['ads']);
            $parent = $_POST['cat'];



            $formerror = array();
            //check if the cat used in database
            $stmt = $con->prepare("select * From categories WHERE CatName=?");
            $stmt->execute(array($catname));
            $row = $stmt->rowCount();
            if ($row > 0) {
                $formerror[] = "This Name is allredy used";
            }
            //check if the cat used in database
            //----------------------------------------------------------
            if ($catname == '') {
                $formerror[] = "you have to fill the Categories name";
            }
            if (count($formerror) == 0) {
                $stmt = $con->prepare("INSERT INTO `categories` (`CatName`, `Description`, `Ordaring` ,`visibility` ,`Allow_Comment`,`Allow_Ads`,`parent`) VALUES (?,?,?,?,?,?,?)");
                $stmt->execute(array($catname,$catdiscip,$order,$vis,$comment,$ads,$parent));
                ?>
                <div class="container updiv ">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo "<div >success</div>"; ?>
                </div>
            <?php
                header("refresh:5;url=?do=add");
            }
            else {


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
        }

      
    }
     elseif ($do == 'delete') {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : -1;
        try {

            $stmt = $con->prepare("SELECT * FROM `categories` WHERE   CatID=?  LIMIt 1 ");
            $stmt->execute(array($catid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
        } catch (Exception $e) {
            echo $e;
        } 
        if ($count>0) {
            try {
            $stmt = $con->prepare("DELETE FROM categories WHERE CatID=?");
            $stmt->execute(array($catid));
            ?>
            <div class="container updiv ">
                <i class="fas fa-thumbs-up"></i>
                <?php echo "<div >success</div>"; ?>
            </div>
        <?php
        header("refresh:5;url=?do=manage");
            }catch (Exception $e) {
                echo $e;
            }
        }
        else
        {
            ?>
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
            <p class="dogp  d-flex justify-content-center">not allwed</p>
        <?php
            header("refresh:5;url=?do=manage");
        }
      
        
        
    }
    include "Inclodes/templates/footer.php";
}

else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>

