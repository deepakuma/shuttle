<?php
require "header.php";
?>
<link rel="stylesheet" href="style.css">
<main>
<div class="col-md-0 col-xs-20 p-3 wrap" style="color:black; border-radius:20px" >
    <section class="section-default" style="color: black">
        <h2>
            Signup Here
        </h2>
        <form  class="form-signup" action="includes/signup.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username" required>
        <input type="text" name="mail" placeholder="E-mail" required>
        <input type="text" name="roll" placeholder="Rollno" required>
        <input type="password" name="pwd" placeholder="Password" required>
        <input type="password" name="pwd-repeat" placeholder="Repeat password" required>
        <button type="submit" name="signup-submit">Signup</button>
    
    </form>
    </section>
</div>

</main>

<?php
require "footer.php";
?>