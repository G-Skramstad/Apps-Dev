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
     

    </tr>
    <?php endforeach; ?> 
     
    
    
</table>


<?php require_once '../view/footer.php'; ?>
