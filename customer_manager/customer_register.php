<?php  require_once '../view/header.php'; ?> 

<span><?php echo $registeration_message?></span><br>

<h1>Register Customer</h1>
<form action="customer_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="add_customer" /> 
    
    <label for="email">Email</label>
    <input type="email" name ="email" maxlength="255" required>
    <br>
   <label for="userName">UserName</label>
    <input type="text" name ="userName" maxlength="60" required>
    <br>
    <label for="password">Password</label>
    <input type="text" name ="password" maxlength="60" required>
    <br>
    <label for="email"></label>
    <input type="submit" value="register">
</form>
<?php require_once '../view/footer.php'; ?>