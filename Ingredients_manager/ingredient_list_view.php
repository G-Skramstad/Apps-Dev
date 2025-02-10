<?php require_once '../view/header.php'; ?>
<br>


<table>
    <tr>
        <th>ID</th>
        <th>Recipe Name</th>
        <th>Status</th>
        <th>view recipe</th>

   
    </tr>
     <?php foreach ($ingredients as $ingredients) :?>
    <tr>
     <td><?php echo $ingredients ->getId(); ?></td>
      <td><?php echo $ingredients-> getName(); ?></td>
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
              <input type="hidden" name="ingreidientID" value="<?php echo $ingredients ->getId(); ?>">
              <button type="submit"> view </button>
          </form>
      </td>
      
      
        
    <?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>
