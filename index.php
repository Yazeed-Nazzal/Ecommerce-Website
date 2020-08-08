<?php
session_start();
$pagetitle = "Home Page";
include "init.php";
?>

<div class="container scatdiv">
     <div class = "row">
     <?php
     $record = getall('items','Date',"DESC","WHERE approve =1");
     foreach($record as $v){
         ?>
             <div class="col-md-3 col-6">
              <div class ="thumbnail ">
                      <span class ="pricr-tag">$<?php echo $v['Price']; ?></span>
                      <img src="uploads\items\<?php echo $v['Image']?>" alt="..." class="img-thumbnail ">
                      <div class="caption">
                            <h4 ><a class="itema" href="items.php?itemid=<?php echo $v['ItemID'] ?>"><?php echo $v['ItemName']; ?></a></h4>
                            <p><?php echo $v['Description']; ?></p>
                            <p class="float-right idate"><?php echo $v['Date']; ?></p>
                            

                     </div>
             
          </div>
             </div>



        <?php

     }
      ?>

         
    </div>
  
</div>




<?php

$q = $con->prepare("SELECT * FROM users where Username like '%nazal%'");
$q->execute();

include $temp."/footer.php";
?>