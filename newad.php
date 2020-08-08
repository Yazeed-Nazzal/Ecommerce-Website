<?php
session_start();
$pagetitle = "add ads";
include "init.php";
if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      $formerorr = array();
      $avatar = $_FILES['avatar'];
      $avatarname = $avatar['name'];
      $avatartype = $avatar['type'];
      $avatarsize = $avatar['size'];
      $avatartemp = $avatar['tmp_name'];
      $allowavatarextantion = array("jpeg","jpg","png","gif");
     

      $avatarextantion = explode(".",$avatarname);
      $avatarextantion = strtolower( end($avatarextantion));
     
     
      $name   =  filter_var($_POST['name'],FILTER_SANITIZE_STRING);
      if (!is_numeric($_POST['Price'])) {
        $formerorr[]='the price must be number';
          
      }
      $des     =  filter_var($_POST['Description'],FILTER_SANITIZE_STRING);
      $price   =  filter_var($_POST['Price'],FILTER_SANITIZE_NUMBER_INT);
      $country = filter_var( $_POST['Country'],FILTER_SANITIZE_STRING);
      $state   =  filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
      $cat     =  filter_var($_POST['cat'],FILTER_SANITIZE_NUMBER_INT);
      //start username check
      if ($name=='') {
        $formerorr[]='you have to put your item name';
      }
      if (strlen($name)<4) {
        $formerorr[]='The  name shuld be  longer than 4 charactar';
      }
      //end username check
      //start des check
      if ($des=='') {
        $formerorr[]='you have to put your item descraption';
      }
      if (strlen($des)<10) {
        $formerorr[]='The  description shuld be  longer than 10 charactar';
      }
      //end des check
      //start price check
      if ($price=='') {
        $formerorr[]='you have to put item price';
      }
      if (strlen($price)<1) {
        $formerorr[]='The  description shuld be  longer than 1 charactar';
      }
      //end price check
       //start cont check
      if ($country=='') {
        $formerorr[]='you have to put your item country';
      }
      if (strlen($country)<2) {
        $formerorr[]='The country  name shuld be  longer than 2 charactar';
      }
      if(  !in_array($avatarextantion,$allowavatarextantion) ){
        $formerror[] = "this extinsion is not allwed";

    }
    if ($avatarsize>2000000) {
        $formerror[] = "This img is not allwed big size";
    }
 
       //end cont check
       if (count($formerorr)>0) {
                 
              ?>
              <div class="container updiv ">
                  <i class="fas fa-exclamation-triangle"></i>
                  <?php foreach ($formerorr as $v) {
                      echo "<div>" . $v . "</div>";
                  }
                  ?>
              </div>

          <?php
           header("refresh:4;url=newad.php");
             
    }
    else{
        try {
            rand(0,100000);
            $avatarimg =  rand(0,1000000000) . "_" . $avatarname;
            move_uploaded_file($avatartemp,"uploads\items\\".$avatarimg);
            $stmt = $con->prepare("INSERT INTO `items` (`ItemName`,`Description`,`Price`,`Date`,`MadeCountry`,`Status`,`Cat_ID` ,`User_ID`,`Image`) VALUES (?,?,?,now(),?,?,?,?,?)");
            $stmt->execute(array($name,$des,$price,$country,$state,$cat,$sessionuser,$avatarimg));
            ?>
            <div class="container updiv ">
                <i class="fas fa-thumbs-up"></i>
                <?php echo "<div >success</div>"; ?>
            </div>
        <?php
            // header("refresh:5;url=?do=add");
        } catch (Exception $e) {
            echo $e;
        }
    }
    }
    else{
    

    
    ?>
    <div class="container">
    <h2 class="d-flex justify-content-start edh">Add New Item</h2>
</div>

<div class="container edcon">
    <div class="row">
    <div class = "edfilds">
        <form class="col-sm" action="newad.php" method="POST"  enctype="multipart/form-data">
            <!-- Start Name Field -->
            <div class="form-group ed">
                <label class="input-group-append" for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control live-name" required  autocomplete="off" name="name" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Name Of The Item ">

            </div>
            <!-- end Name Field -->
            <!-- Start Description Field -->
            <div class="form-group ed">
                <label class="input-group-append" for="exampleInputEmail1">Description</label>
                <input type="text" class="form-control  live-des " required autocomplete="off" name="Description" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Description Of The Item ">

            </div>
            <!-- end Description Field -->
            <!-- start Price Field -->
            <div class="form-group ed">
                <label class="input-group-append" for="exampleInputEmail1">Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" class="form-control live-price" required  autocomplete="off" name="Price" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" Price Of The Item ">

            </div>
            <!-- end Price Field -->
            <!-- start MadeCountry Field -->
            <div class="form-group ed">
                <label class="input-group-append" for="exampleInputEmail1">Country&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" class="form-control" require autocomplete="off" required name="Country" value="" id="exampleInputEmail1" aria-describedby="emailHelp" required placeholder=" MadeCountry Of The Item ">

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
    
       
            <!-- start cat Field -->
            
            <div class="form-group ed">
                <label for="inputState">Categories</label>
                <select id="inputState" name="cat" class="form-control ">
                    <option value="-1" selected>Choose...</option>
                    <?php
                    
                    $row = getall('categories','CatName',"ASC","WHERE parent = 0");
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
                              <label>Your item image</label>
                              <input type="file" class="form-control" autocomplete="off" name="avatar"  id="exampleInputPassword1" value="" placeholder="Your img">
             </div>





            <div class="form-group ed ">
                <input type="submit" class="btn btn-primary edbtn" value="Add">
            </div>


        </form>
        </div>
      
        <div class=" col-sm ">
                    <div class ="thumbnail  live-show">
                                <span class ="pricr-tag prview-price">$100</span>
                                <img src="Layout/Images/avatar.png" alt="..." class="img-thumbnail adimg">
                                <div class="caption">
                                        <h4 class="prview-name" >name</h4>
                                        <p class='prview-des'>descipe</p>

                                </div>
                        
                    </div>
        </div>
        </div>
    <?php
    
}
}
include ($temp."/footer.php");
    ?>