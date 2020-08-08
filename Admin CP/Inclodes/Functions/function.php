<?php


//name the page 
function gettitle()
{
 global $pagetitle;
 if (isset($pagetitle)) {
    echo lang($pagetitle);
 }
 else {
     echo "non";
 }  
}
//name the page 


//-----------------------------------------------
//redirect the page if error happened

function redirect($errormass , $repage = 'non', $second =5,$stat)
{

    if ($stat=0) {
        ?>
    <i class="fas fa-dog dog d-flex justify-content-center"></i>
    <p class="dogp  d-flex justify-content-center">$errormass</p>
    <?php
    header("refresh:$second; url=$repage");
    }
    else
    {   ?>
        <div class="container updiv ">
            <i class="fas fa-thumbs-up"></i>
            <?php echo "<div >success</div>"; ?>
            
        </div>
    <?php
          header("refresh:$second; url=$repage");
    }
   
 
}
//-----------------------------------------------------------------

// this function is used to get the count from data base

 function getcount($item , $table,$cond='')
{
    global $con;
    $stmt1 = $con->prepare("SELECT count($item) From  $table".$cond);  
    $stmt1->execute();

    return $stmt1->fetchColumn();
}

//-------------------------------------------------------------------

//get lastest record 

function getlastest($table , $ordeeby , $lim =5){
    global $con;
    $lasteststmt = $con->prepare("SELECT * FROM $table ORDER by $ordeeby  DESC LIMIT $lim");
    $lasteststmt->execute();
    $rows = $lasteststmt->fetchAll();

    return $rows;
}

//get cat
function getcat($cond='')
{
    global $con;

    $stmt1 = $con->prepare("SELECT* From categories $cond  order by CatName ");  
    $stmt1->execute();

    $cats = $stmt1->fetchAll();
    return $cats;

}

function getall($table,$order='',$way = " ASC",$cond=''){
    global $con;
    $stmt = $con->prepare("SELECT* FROM $table  $cond  order by $order  $way");
    $stmt->execute();
    $all = $stmt->fetchAll();
    return $all; 
}

?>