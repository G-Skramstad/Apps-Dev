<?php require_once '../view/header.php'; ?>
<br>
<table>
    <tr>
        <th>description</th>
        <th>Quantity</th>
        <th>Notes</th>
        <th>Store</th>
        <th>Status</th>
        <th>fulfilled by</th>
        <th></th>
    </tr>
    <tr>
    <form action="wish_list_manager/index.php" method="POST">
        <input type="hidden" name="controllerRequest" value="add_list_item" > 
        <input type="hidden" name="wishListID" value="<?php echo $wishListId; ?>">
        <td><input type="text" name="description"></td>
        <td><input type="number" id="quantity" name="quantity" min="1" value="1"></td>
        <td><input type="text" name="notes"></td> 
        <td>
            <select name="store">
                <?php foreach ($stores as $store) :?>
                <option value="<?php echo $store -> getId(); ?>"><?php echo $store -> getName(); ?></option>
                <?php endforeach; ?> 
            </select>
        </td>
        <td>Active</td>
        <td>N/A</td>
        <td><input type="submit"></td>
        
    </form>


    
    </tr>
    <?php foreach ($wishListItems as $wishListItem) :?>
    <tr>
    <td><?php echo $wishListItem ->getDesc(); ?></td>
      <td><?php echo $wishListItem-> getQuantity().' '; ?></td>
      <td ><?php echo $wishListItem-> getNotes(); ?></td>
      <td ><?php echo $wishListItem-> getStore(); ?></td> 
      <td><?php echo $wishListItem-> getIsActive(); ?></td><!-- comment -->
      <td><?php echo $wishListItem-> getFulfilledBy();?>
      <?php if ($wishListItem->getFulfilledBy() == ""): ?>
    <form action="wish_list_manager/index.php" method="POST">
        <input type="hidden" name="controllerRequest" value="fulfill" />
        <input type="hidden" name="itemID" value="<?php echo $wishListItem->getId(); ?>" />
        <input type="hidden" name="wishListID" value="<?php echo $wishListId; ?>">
        <input type="submit" value="Fulfill">
    </form>
    <?php endif; ?></td>
      <td>
         <form action="wish_list_manager/index.php" method="POST">
             <input type="hidden" name="controllerRequest" value="<?php echo ($wishListItem->getIsActive() == 1) ? 'Deactivate' : 'Activate'; ?>_item" /> 
              <input type="hidden" name="wishListID" value="<?php echo $wishListId; ?>">
              <input type="hidden" name="itemID" value="<?php echo $wishListItem-> getId(); ?>" />
              <input type="submit" value="<?php echo ($wishListItem->getIsActive() == 1) ? 'Deactivate' : 'Activate'; ?>">
              
          </form> 
      </td>

    </tr>
    <?php endforeach; ?> 
     
    
    
</table>


<?php require_once '../view/footer.php'; ?>
