<?php
session_start();
?>

<link rel="stylesheet" href="style.css">
  <main>
  
  <?php
if(isset($_SESSION['userId'])){
    echo '<form action="includes/logout.inc.php" method="post">
    <button type="submit" name="logout-submit">
      Logout
    </button>
  </form>';
  require "section.php";
}
else{
  
    echo '<div class="col-md-0 col-xs-20 p-3 header-login">
     <h2 >User Login Here</h2>
    <form action="includes/login.inc.php" method="post">
<input type="text" name="mailuid" placeholder="E-mail/Username">
<input type="password" name="pwd" placeholder="Password">
<button type="submit" name="login-submit">Login</button>
<p> New User? <a href="signup.php"> Sign up</a> </p>
</form>
</div>

<div class="col-md-0 col-xs-20 p-5 header-login">
<h2 > Driver Login Here</h2>
<form action="includes/login.inc.php" method="post">
<input type="text" name="mailuid" placeholder="E-mail/Username">
<input type="password" name="pwd" placeholder="Password">
<button type="submit" name="login-submit">Login</button>
</form>
</div>';
}

   ?>
  </main>
