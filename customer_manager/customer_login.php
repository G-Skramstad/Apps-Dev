<?php require_once '../view/header.php'; ?>
<h1>Please Log in</h1>

   <?php  echo $errorMessage ?>
   <form method="POST" action="customer_manager/index.php">
   <input type="hidden" name="controllerRequest" value="validate_login">  
    <!-- Add the code-->
    <label>UserName: </label> <input type="text" name="userName" value="<?php echo $userName?>">
    <br>
    <label>Password: </label> <input type="text" name="password" value="">
    <br>
    <label></label>
    <input type="submit" value="Login">
</form>
<?php require_once '../view/footer.php'; ?>