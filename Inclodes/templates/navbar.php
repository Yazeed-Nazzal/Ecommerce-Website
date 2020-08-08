
<nav class="container-fluid upar">
      <div class="container upercon">
        <?php
        if (isset($_SESSION['user'])) {
          $status = checkstatus($_SESSION['userid']);
          ?>
          <div class="float-left">
            <?php 
             if ($status==0) {
              ?>
               <p  class ="uperspan notcro">welcome <?php echo $_SESSION['user']; ?></p>
              <?php
            }
?>
           
          </div>
          <div  class="float-right">
          <a class="prfile" href="profile.php"><span  class ="uperspan">profile</span></a>
          <a class="prfile" href="newad.php"><span  class ="uperspan">new AD</span></a>
          <a class="prfile" href="profile.php#my-ads"><span  class ="uperspan">My ADS</span></a>
          <a class="prfile" href="logout.php"><span  class ="uperspan">logout</span></a>
          </div>
          <?php
       
          if ($status==1) {
            ?>
             <span  class ="uperspan">your account is not active yet</span>
            <?php
          }
    
        }
        else 
        {
          ?>
            <a class="float-right loghsin" href="login.php">
          <span class ="uperspan">Login/Signup</span>
        </a>
      
        <?php
        }
        ?>
      
      <div class="clear"></div>
      </div>
      </nav>

<nav class="navbar  navbar-expand-lg navbar-dark  navbar-default x main-store-nav">
  <a class="navbar-brand" href="#">Y Store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
     
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><?php echo lang('home page');   ?></a>
      </li>
    
           <?php 
                 $cats = getcat("WHERE parent =0");
                 foreach ($cats as $v) {
                   echo "<li class='nav-item '>";
                   echo "<a class='nav-link' href='categories.php?pageid=".$v['CatID']."&pagename=". str_replace(" ","-",$v['CatName']) . "'>".$v['CatName']."</a>";
                   echo "</li>";
                  }
           
           
           ?>
         
        </div>
      
    </ul>
 
</div>
  
  </div>
  
</nav>

