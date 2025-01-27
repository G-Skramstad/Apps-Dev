<?php require_once '../view/header.php'; ?>
    <h1>Register Process</h1>
    <h2 id="error"><?php echo $errorMessage; ?></h2>
  <form method="POST" action="customer_manager/index.php">
      <input type="hidden" name="controllerRequest" value="register_customer" /> 
  
      
      
      
      <input type="submit" value="Register">
  </form>


  <?php require_once '../view/footer.php'; ?>