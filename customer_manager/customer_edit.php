  <?php require_once '../view/header.php'; ?>
<h1>Edit Customer</h1>
<form action="customer_manager/index.php" method="post">
<input type="hidden" name="controllerRequest" value="update_customer" /> 
    <label>Customer:</label>
    <input class="form" name="customer_id" value="<?php echo $user ->getId(); ?>" readonly>
    <br>
            <label for="firstName">user Name</label>
            <input type="text" name ="firstName" 
                   value="<?php echo $user-> getUserName(); ?>" maxlength="60" required>
            <br>

            <label for="email">Email</label>
            <input type="text" name ="email" 
                   value="<?php echo $user-> getEmail(); ?>" maxlength="255" required>
            <br>
            <label for="password">Password</label>
            <input type="text" name ="password" 
                   value="" maxlength="60" required>
            <br>   
            <label for="phone">Phone</label>
            
            <input type="checkBox" name="active" 
            <?php            
                if ($user-> getIsActive() == 1) {
                    echo 'checked';
                }
            ?>> 
            
            <label for="active"> active</label>
            
            <br>
    <input type="submit" value="Save Changes">

</form>
 <?php require_once '../view/footer.php'; ?>