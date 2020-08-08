<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {
// rename the title
$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
$pagetitle = "member";
if ($do == 'manage') {
    $pagetitle = "comments";
} elseif ($do == 'update') {
    $pagetitle = "update";
} elseif ($do == 'delete') {
    $pagetitle = "delete";
} elseif ($do == 'approve') {
    $pagetitle = "approve";
} else {
    $pagetitle = "error";
}
// rename the title
include "init.php";
if ($do == 'manage') {
    $stmt = $con->prepare("SELECT comments.* , users.UserName , items.ItemName FROM comments
                                                                                          INNER JOIN users ON users.UserID = comments.user_id
                                                                                          INNER JOIN items ON items.ItemID = comments.item_id ");
                                                                                          
   $stmt->execute();
    $rows = $stmt->fetchAll();


    
?>

<div class="container manc">
    <h3 class="text-center">comments manage</h3>
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
            foreach ($rows as $row) {
                echo "<tr>";
                echo "<th  scope='col'>";
                echo $row['Comment_ID'];
                echo "</th>";
                echo "<td  scope='col'>";
                echo $row['Comment'];
                echo "</td>";
                echo "<td  scope='col'>";
                      echo $row['UserName'];
                echo "</td>";
                echo "<td  scope='col'>";
                     echo $row['ItemName'];
                echo "</td>";
                echo "<td  scope='col'>";
                echo $row['Com_Date'];
                echo "</td>";
            ?>
                <td>
                    
                    <a type="button" class="btn tre confirm " href="<?php echo "?do=delete&commentid=" . $row['Comment_ID']  ?>"><i class="fas fa-comment-slash"></i> Delete</a>
                    <?php
                    if ($row['Status']==0) {
                    ?>
                        <a type="button" class="btn tac" href="<?php echo "?do=approve&commentid=" . $row['Comment_ID']  ?>"><i class="fas fa-check"></i>approve</a>
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
elseif ($do == 'approve') {
    $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : -1;
    
    try {

        $stmt = $con->prepare("UPDATE comments  set  `Status`  =1 where Comment_ID=".$commentid);
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
  
}
elseif ($do == 'delete')
{
    $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : -1;
    try {

        $stmt = $con->prepare("SELECT * FROM `comments` WHERE   Comment_ID=?  LIMIt 1 ");
        $stmt->execute(array($commentid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count>0) {
            $stmt = $con->prepare("DELETE FROM comments WHere Comment_ID=?");
            $stmt->execute(array($commentid));
            ?>
            <div class="container updiv ">
                <i class="fas fa-thumbs-up"></i>
                <?php echo "<div >success</div>"; ?>
            </div>
        <?php
             header("refresh:5;url=comments.php");
            
        }
        else
        {
            ?>
            <div class="container updiv ">
            <i class="fas fa-dog dog d-flex justify-content-center"></i>
        <p class="dogp  d-flex justify-content-center">not allwed</p>
            </div>

        <?php
            //error
            header("refresh:5;url=comments.php");
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
        header("refresh:5;url=comments.php");
        //errpr
  
}

}
else
{
    ?>
    <i class="fas fa-dog dog d-flex justify-content-center"></i>
    <p class="dogp  d-flex justify-content-center">not allwed</p>
    

<?php


}

}
include $temp."/footer.php";

?>


