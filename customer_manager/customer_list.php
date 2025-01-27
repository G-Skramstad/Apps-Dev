<?php require_once '../view/header.php'; ?>
<h1>Customers</h1>
<form action="customer_manager/index.php" method="POST">
    <label id="search">Search by last name:</label>
    <input type="text" name="last_name_search" value="<?php if($last_name !=null){echo $last_name;} ?>">
    <input type="hidden" name="controllerRequest" value="search_customer" /> 
    <input type="submit" value="Search"><br>
    </form>

<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>City</th>
        <th>State</th>
        <th>ZIP Code</th>
        <th>Status</th>
        <th>view Lists</th>
        <th>Edit</th>
   
    </tr>
     <?php foreach ($users as $user) :?>
    <tr>
     <td><?php echo $user ->getId(); ?></td>
      <td><?php echo $user-> getFirstName().' '.$user-> getLastName(); ?></td>
      <td ><?php echo $user-> getCity();; ?></td>
      <td ><?php echo $user-> getState(); ?></td> 
      <td ><?php echo $user-> getZip(); ?></td>
      <td ><?php 
        if ($user-> getActive() == 1){
            echo "Active";
        }
        else{
            echo "Not Active";
        }
                
      ?></td>
      <td>
        <form action="wish_list_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="userWishes" /> 
            <input type="hidden" name="customer_id" value="<?php echo $user ->getId(); ?>">
            <input type="submit" value="view">
            
        </form>
        </td>
        <td>
        <?php if ($userID == $user ->getId() || $userRoleID == 2): ?>
        <form action="customer_manager/index.php" method="POST">
            <input type="hidden" name="controllerRequest" value="show_edit_customer_veiw" /> 
            <input type="hidden" name="customer_id" value="<?php echo $user ->getId(); ?>">
            <input type="submit" value="Edit">
            
        </form>
        </td>
    </tr>
    <?php endif; ?>
    <?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>