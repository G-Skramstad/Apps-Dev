<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Skramstad Wish List </title>
        
       <!-- Change the base href  to the correct URL!!!!! -->     
       <base href="http://localhost/projects/Skramstad-WishList/">
        
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    
</head>

<!-- the body section -->
<body>
    <main>

<header>
    <h1 id="header">Skramstad Wish List</h1>
</header>
        <ul id="header_ul">
            <li><a href="index.php" >Home</a>
        </li> 
        <?php if ($userID == 0): ?>
        <li>
            <a href="customer_manager/index.php?controllerRequest=add_customer_view">User sign up</a>
        </li>
        <?php endif; ?>
        <?php if ($userID == 0): ?>
        <li>
            <a href="customer_manager?controllerRequest=login_customer_view">User login</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="customer_manager?controllerRequest=list_customers_view">User list</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="wish_list_manager?controllerRequest=myWishes">My Wishes</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="wish_list_manager?controllerRequest=wishLists">Wish Lists</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="wish_list_manager?controllerRequest=wishesGranted">Wishes Granted</a>
        </li>
        <?php endif; ?>
        <?php if ($userRoleID == 2): ?>
        <li>
            <a href="store_manager?controllerRequest=stores">Stores</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="wish_list_manager?controllerRequest=create_new_list_view">create list</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
       <li><a href="index.php?controllerRequest=logOut" >log Out</a></li> 
        <?php endif; ?>
       
        </ul>
        
    
     
    
