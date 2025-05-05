
<?php require_once '../view/header.php'; ?>
<h1>Recipes</h1>
<form action="recipe_manager/index.php" method="POST">
    <label id="search">Search by Recipe Name:</label>
    <input type="text" name="search_name" value="<?php ?>">
    <input type="hidden" name="controllerRequest" value="search_recipe" /> 
    <input type="submit" value="Search"><br>
</form>
<div id="limit">
<table>
    <tr>
        
        <th>Recipe Name</th>
        <th>description</th>
        <th>Status</th>
        <th>view recipe</th>

   
    </tr>
     <?php foreach ($recipes as $recipe) :?>
    <tr>
     
      <td><?php echo $recipe-> getName(); ?></td>
      <td><?php echo $recipe-> getDescription(); ?></td>
      <td ><?php 
        if ($recipe-> getIsActive() == 1){
            echo "Active";
        }
        else{
            echo "Not Active";
        }?>
      </td>
      <td>
          <form action="recipe_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="view_recipe" /> 
              <input type="hidden" name="id" value="<?php echo $recipe ->getId(); ?>">
              <button type="submit"> view </button>
          </form>
      </td>
     <?php if ($userRoleID == 1 || $recipe -> getUserID() == $userID): ?>
      <td>
          <form action="recipe_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="Edit-view" /> 
              <input type="hidden" name="id" value="<?php echo $recipe ->getId(); ?>">
              <button type="submit"> edit </button>
          </form>
      </td>
      
    <?php endif?>
    <?php endforeach; ?>
      
</table>
</div>
<?php require_once '../view/footer.php'; ?>