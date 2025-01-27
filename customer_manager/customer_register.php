<?php  require_once '../view/header.php'; ?> 
<h1>Register Process</h1>
<span><?php echo $registeration_message?></span><br>

<h1>Register Customer</h1>
<form action="customer_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="add_customer" /> 
    <label for="firstName">First Name</label>
    <input type="text" name ="firstName" maxlength="60" required>
    <br>
    <label for="lastName">Last Name</label>
    <input type="text" name ="lastName" maxlength="60" required>
    <br> 
    <label for="password">Address</label>
    <input type="text" name ="address" maxlength="60" required>
    <br> 
    <label for="password">City</label>
    <input type="text" name ="city" maxlength="40">
    <br> 
    <label for="password">State</label>
    <input type="text" name ="state" maxlength="2">
    <span> *max 2 characters use abbreviation</span>
    <br> 
    <label for="password">Zip Code</label>
    <input type="text" name ="zip" maxlength="10">
    <br> 
    <label for="email">Email</label>
    <input type="email" name ="email" maxlength="255" required>
    <br>
    <label for="phone">Phone</label>
            <input type="text" name ="phone" maxlength="20" required>
            <br>
    <label for="password">Password</label>
    <input type="text" name ="password" maxlength="60" required>
    <br>
    <label for="email"></label>
    <input type="submit" value="register">
</form>
<?php require_once '../view/footer.php'; ?>