<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Collaborative Cooking </title>
        
       <!-- Change the base href  to the correct URL!!!!! -->     
       <base href="http://localhost/projects/Apps-Dev-Project/">
        
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    
</head>

<!-- the body section -->
<body>
    <main>

<header>
    <h1 id="header">Collaborative Cooking</h1>
</header>
        <ul id="header_ul">
            <li><a href="index.php" >Home</a>
        </li> 
        <?php if ($userID == 0||true): ?>
        <li>
            <a href="customer_manager/index.php?controllerRequest=add_customer_view">User sign up</a>
        </li>
        <?php endif; ?>
        <?php if ($userID == 0 ||true): ?>
        <li>
            <a href="customer_manager?controllerRequest=login_customer_view">User login</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0||true): ?>
        <li>
            <a href="customer_manager?controllerRequest=list_customers_view">User list</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0||true): ?>
        <li>
            <a href="Recipe_manager?controllerRequest=myWishes">My Recipes</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0||true): ?>
        <li>
            <a href="Recipe_manager?controllerRequest=veiw-all-recipes">Recipes</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0||true): ?>
        <li>
            <a href="Recipe_manager?controllerRequest=createRecipe1">Recipe Builder</a>
        </li>
        <?php endif; ?>
        <?php if ($userRoleID == 2||true): ?>
        <li>
            <a href="Ingredients_manager?controllerRequest=stores">Ingredients</a>
        </li>
        <?php endif; ?>
        
        <?php if ($userID != 0||true): ?>
       <li><a href="index.php?controllerRequest=logOut" >log Out</a></li> 
        <?php endif; ?>
       
        </ul>
        
    
     
    
