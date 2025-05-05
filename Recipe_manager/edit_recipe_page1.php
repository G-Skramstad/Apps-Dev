<?php require_once '../view/header.php'; ?>
<h1>Enter the Name and Description of Your Recipe</h1>

   <?php  echo $errorMessage ?>
   <form method="POST" action="Recipe_manager/index.php">
   <input type="hidden" name="controllerRequest" value="EditRecipe2">  
    <!-- Add the code-->
    <label>Name: </label> <input type="text" name="name" value="<?php echo $name?>">
    <br>
    <label>Description: </label> <input type="text" name="description" value="<?php echo $description?>">
    <br>
    <label></label>
    <input type="submit" value="Next">
</form>
<?php require_once '../view/footer.php'; ?>