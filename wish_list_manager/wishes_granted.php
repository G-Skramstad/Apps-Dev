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
      <td><?php echo $wishListItem-> getFulfilledBy(); ?></td>
      

    </tr>
    <?php endforeach; ?> 
     
    
    
</table>


<?php require_once '../view/footer.php'; ?>
