<?php

?>
<form action="test.php" method="GET">
<input type="text" name="1" value="yyy">
<input type="text" name="2" value="yyy">
<input type="submit" value="save">
</form>
<?php
if ( isset($_GET)) {
   foreach($_GET as $v => $x){
          echo "id=". $v ."answer=".$x."<br>";
   }

}

?>