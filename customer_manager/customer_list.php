<?php require_once '../view/header.php'; ?>
<h1>Customers</h1>
<form action="customer_manager/index.php" method="POST">
    <label id="search">Search by Username:</label>
    <input type="text" name="username_search" value="<?php if($username !=null){echo $username;} ?>">
    <input type="hidden" name="controllerRequest" value="search_customer" /> 
    <input type="submit" value="Search"><br>
    </form>
<div id="limit">
<table>
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Status</th>
        <th>view recipes</th>
        
        <th>Edit</th>
   
    </tr>
     <?php foreach ($users as $user) :?>
    <tr>
     <td><?php echo $user ->getId(); ?></td>
      <td><?php echo $user-> getUserName(); ?></td>
      
      <td ><?php 
        if ($user-> getIsActive() == 1){
            echo "Active";
        }
        else{
            echo "Not Active";
        }
                
      ?></td>
      <td>
        <form action="Recipe_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="UserRecipies" /> 
            <input type="hidden" name="customer_id" value="<?php echo $user ->getId(); ?>">
            <button type="submit">View</button>
            
        </form>
        </td>
        <td>
        <?php if ($userID == $user ->getId() || $userRoleID == 1): ?>
        <form action="customer_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="show_edit_customer_veiw" /> 
            <input type="hidden" name="customer_id" value="<?php echo $user ->getId(); ?>">
            <button type="submit">Edit</button>
            
        </form>
        </td>
    </tr>
    <?php endif; ?>
    <?php endforeach; ?>
</table>
</div>
<?php require_once '../view/footer.php'; ?>