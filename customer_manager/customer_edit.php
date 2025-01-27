  <?php require_once '../view/header.php'; ?>
<h1>Edit Customer</h1>
<form action="customer_manager/index.php" method="post">
<input type="hidden" name="controllerRequest" value="update_customer" /> 
    <label>Customer:</label>
    <input class="form" name="customer_id" value="<?php echo $user ->getId(); ?>" readonly>
    <br>
            <label for="firstName">First Name</label>
            <input type="text" name ="firstName" 
                   value="<?php echo $user-> getFirstName(); ?>" maxlength="60" required>
            <br>
            <label for="lastName">Last Name</label>
            <input type="text" name ="lastName" 
                   value="<?php echo $user-> getLastName(); ?>" maxlength="60" required>
            <br> 
            <label for="address">Address</label>
            <input type="text" name ="address" 
                   value="<?php echo $user-> getAddress(); ?>" maxlength="60" required>
            <br> 
            <label for="password">City</label>
            <input type="text" name ="city" 
                   value="<?php echo $user-> getCity(); ?>" maxlength="40">
            <br> 
            <label for="password">State</label>
            <input type="text" name ="state" 
                   value="<?php echo $user-> getState(); ?>" maxlength="2">
            <span> *max 2 characters use abbreviation</span>
            <br> 
            <label for="password">Zip Code</label>
            <input type="text" name ="zip" 
                   value="<?php echo $user-> getZip(); ?>" maxlength="10">
            <br> 
            <label for="email">Email</label>
            <input type="text" name ="email" 
                   value="<?php echo $user-> getEmail(); ?>" maxlength="255" required>
            <br>
            <label for="password">Password</label>
            <input type="text" name ="password" 
                   value="<?php echo $user-> getPasswordC(); ?>" maxlength="60" required>
            <br>   
            <label for="phone">Phone</label>
            <input type="text" name ="phone" 
                   value="<?php echo $user-> getPhone(); ?>" maxlength="20" required>
            <br>
            <input type="checkBox" name="active" 
            <?php            
                if ($user-> getActive() == 1) {
                    echo 'checked';
                }
            ?>> 
            
            <label for="active"> active</label>
            
            <br>
    <input type="submit" value="Save Changes">

</form>
 <?php require_once '../view/footer.php'; ?>