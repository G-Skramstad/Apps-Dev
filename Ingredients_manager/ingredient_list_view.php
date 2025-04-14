<?php require_once '../view/header.php'; ?>
<br>

<form action="ingredients_manager/index.php" method="POST">
    <label id="search">Search by Ingredient Name:</label>
    <input type="text" name="ingredient_name" value="<?php ?>">
    <input type="hidden" name="controllerRequest" value="search_ingredient" /> 
    <input type="submit" value="Search"><br>
</form>
<div id="limit">
<table>
    <tr>
        
        <th>ingredient Name</th>
        <th>Ingredient Type</th>
        <th>Status</th>
        <th>view recipe</th>

   
    </tr>
     <?php foreach ($ingredients as $ingredients) :?>
    <tr>
     
      <td><?php echo $ingredients-> getName(); ?></td>
      <td><?php echo $ingredients-> getIngredientType(); ?></td>
      <td ><?php 
        if ($ingredients-> getIsActive() == 1){
            echo "Active";
        }
        else{
            echo "Not Active";
        }?>
      </td>
      <td>
          <form action="ingredients_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="view_ingreidient" /> 
              <input type="hidden" name="id" value="<?php echo $ingredients ->getId(); ?>">
              <button type="submit"> view </button>
          </form>
      </td>
      
      
        
    <?php endforeach; ?>
</table>
</div>
<?php require_once '../view/footer.php'; ?>
