
<?php require_once '../view/header.php'; ?>
<h1>Customers</h1>
<form action="customer_manager/index.php" method="POST">
    <label id="search">Search by Username:</label>
    <input type="text" name="username_search" value="<?php if($username !=null){echo $username;} ?>">
    <input type="hidden" name="controllerRequest" value="search_customer" /> 
    <input type="submit" value="Search"><br>
    </form>

<table>
    <tr>
        <th>ID</th>
        <th>User Name</th>
        <th>Status</th>
        <th>view comments</th>
        <th>Edit</th>
   
    </tr>
     <?php foreach ($recipes as $recipe) :?>
    <tr>
     <td><?php echo $recipe ->getId(); ?></td>
      <td><?php echo $recipe-> getName(); ?></td>
      
      <td ><?php 
        if ($recipe-> getIsActive() == 1){
            echo "Active";
        }
        else{
            echo "Not Active";
        }
                
      ?></td>
      
      
        
    <?php endforeach; ?>
</table>

<?php require_once '../view/footer.php'; ?>