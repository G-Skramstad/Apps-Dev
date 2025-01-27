<?php require_once '../view/header.php'; ?>
<br>
<table>
    <tr>
        
        <th>Wish List Description</th>
        <?php if ($userRoleID == 2) : ?>
        <th>user</th>
        <?php endif ?>
        <th>submit</th>

    </tr>
    
    <form action="wish_list_manager/index.php" method="POST"> 
        <input type="hidden" name="controllerRequest" value="addList" /> 
        <td><input type="text" name="description"></td>
        <?php if ($userRoleID == 2) : ?>
         <td><select name="listUserID">
                <?php foreach ($users as $user) :?>
                <option value="<?php echo $user -> getId(); ?>"><?php echo $user -> getName(); ?></option>
                <?php endforeach; ?> 
            </select></td>
        <?php endif ?>
        <td><input type="submit"></td>
        
    </form>
     
    
    
</table>


<?php require_once '../view/footer.php'; ?>

