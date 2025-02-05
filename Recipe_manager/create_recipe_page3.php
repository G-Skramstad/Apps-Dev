<?php require_once '../view/header.php'; ?>
<h1>Enter the instruction to Your Recipe</h1>

   <?php  echo $errorMessage ?>
   <form method="POST" action="customer_manager/index.php">
   <input type="hidden" name="controllerRequest" value="validate_login">  
    <!-- Add the code-->
    
    <label for="instructions"> instructions </label>

        
        <textarea id="instructions" name="instructions" rows="4" cols="50"></textarea>
        
        <br>
        
        <button type="submit">submit</button>
</form>
<?php require_once '../view/footer.php'; ?>