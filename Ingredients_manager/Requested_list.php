<?php require_once '../view/header.php'; ?>
<br>

<div id="limit">
<table>
    <tr>
        <th>ID</th>
        <th>userID</th>
        <th>Ingredient Name</th>
        <th>Ingredient type</th>
        <th>view recipe</th>

   
    </tr>
     <?php foreach ($ingredients as $ingredients) :?>
    <tr>
     <td><?php echo $ingredients ->getId(); ?></td>
     <td><?php echo $ingredients ->getUserID(); ?></td>
      <td><?php echo $ingredients-> getName(); ?></td>
      <td><?php echo $ingredients-> getIngredientType(); ?></td>
      
      <td>
          <form action="ingredients_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="Approval_view" /> 
              <input type="hidden" name="ingreidientID" value="<?php echo $ingredients ->getId(); ?>">
              <button type="submit"> view </button>
          </form>
      </td>
      
      
        
    <?php endforeach; ?>
</table>
</div>
<?php require_once '../view/footer.php'; ?>
