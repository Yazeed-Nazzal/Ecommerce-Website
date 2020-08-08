
<nav class="navbar   navbar-expand-lg navbar-dark  navbar-default x">
  <a class="navbar-brand" href="#">Y Store</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php"><?php echo lang('Home');   ?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php"><?php echo lang('Gategories');?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php"><?php echo lang('item');   ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="member.php"><?php echo lang('members');   ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="comments.php"><?php echo lang('comments');   ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><?php echo lang('statistics');   ?></a>
      </li>
    </ul>
    <div class=" dropdown righ ">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php echo $_SESSION['username']?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="member.php?do=Edit&userid=<?php echo $_SESSION['ID']?>"><?php echo lang('Edit profile');?></a>
          <a class="dropdown-item" href="#"><?php echo lang('Setting');   ?></a>
          <a class="dropdown-item" href="../index.php"><?php echo lang('visit shop');   ?></a>
          <a class="dropdown-item" href="logout.php"><?php echo lang('logout');  ?></a>
          
         
        </div>
</div>
  
  </div>
  
</nav>
