<?php require_once '../view/header.php'; ?>
<head> <link rel="stylesheet" type="text/css" href="styles/store_list.css"> </head>
<br>


        




<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Active</th>
        <th></th>
        <th>Delete</th>

    </tr>
    <tr>
         <form action="store_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="add_store" /> 
            <td>Id</td>
            <td><input type="text" name="name"></td>
            <td>Active</td>
            <td><input type="submit"></td>
         </form>
    </tr>
    <?php foreach ($stores as $store) :?>
    <tr>
    <form action="store_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="edit_store" />
            <input type="hidden" name="storeID" value="<?php echo $store-> getId(); ?>" />
            <td><?php echo $store ->getId(); ?></td>
            <td><input type="text" name="name" value="<?php echo $store-> getName(); ?>"></td>
             <td ><?php echo ($store->getIsActive() == 1) ? 'Active' : 'deactive'; ?></td>
            <td><input type="submit" value="edit"></td>
         </form>
      <td>
         <form action="store_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="<?php echo ($store->getIsActive() == 1) ? 'Deactivate' : 'Activate'; ?>_store" /> 
              <input type="hidden" name="storeID" value="<?php echo $store-> getId(); ?>" />
              <input type="submit" value="<?php echo ($store->getIsActive() == 1) ? 'Deactivate' : 'Activate'; ?>">
          </form> 
      </td>
      
    </tr>
    <?php endforeach; ?>
     
    
    
</table>


<?php require_once '../view/footer.php'; ?>
