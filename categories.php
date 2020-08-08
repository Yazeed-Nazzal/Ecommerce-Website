<?php
session_start();
$pagetitle = "Categories";
include ("init.php");
?>

<div class="container scatdiv">
    <h2 class="text-center"><?php echo str_replace("-"," ",$_GET['pagename']) ?></h2>
     <div class = "row">
     <?php
     $record = getitems("Cat_ID",$_GET['pageid'],"AND approve =1 ");
     foreach($record as $v){
         ?>
             <div class="col-md-3">
              <div class ="thumbnail ">
                      <span class ="pricr-tag"><?php echo $v['Price']; ?>$</span>
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
include ($temp."/footer.php");
?>