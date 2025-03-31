
<?php require_once '../view/header.php'; ?>
<h1>Customers</h1>
<form action="recipe_manager/index.php" method="POST">
    <label id="search">Search by Recipe Name:</label>
    <input type="text" name="search_name" value="<?php ?>">
    <input type="hidden" name="controllerRequest" value="search_recipe" /> 
    <input type="submit" value="Search"><br>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Recipe Name</th>
        <th>description</th>
        <th>Status</th>
        <th>view recipe</th>

   
    </tr>
     <?php foreach ($recipes as $recipe) :?>
    <tr>
     <td><?php echo $recipe ->getId(); ?></td>
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
      
      
        
    <?php endforeach; ?>
      
</table>

<?php require_once '../view/footer.php'; ?>