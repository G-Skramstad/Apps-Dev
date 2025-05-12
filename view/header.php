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
        <nav>
        <ul id="header_ul">
            <li><a href="index.php" >Home</a>
        </li> 
        <?php if ($userID == 0 ): ?>
        <li>
            <a href="customer_manager/index.php?controllerRequest=add_customer_view">User sign up</a>
        </li>
        <?php endif; ?>
        <?php if ($userID == 0 ): ?>
        <li>
            <a href="customer_manager?controllerRequest=login_customer_view">User login</a>
        </li>
        <?php endif; ?>
        <?php if ($userRoleID == 1): ?>
        <li>
            <a href="customer_manager?controllerRequest=list_customers_view">User list</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="Recipe_manager?controllerRequest=myRecipes">My Recipes</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="Recipe_manager?controllerRequest=veiw-all-recipes">Recipes</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0 && $userActive == 1): ?>
        <li>
            <a href="Recipe_manager?controllerRequest=createRecipe1">Recipe Builder</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="Ingredients_manager?controllerRequest=request_ingredient_view">Request Ingredient</a>
        </li>
        <?php endif; ?>
        <?php if ($userID != 0): ?>
        <li>
            <a href="Ingredients_manager?controllerRequest=ingredient_list_view">Ingredients</a>
        </li>
        <?php endif; ?>
        <?php if ($userRoleID == 1): ?>
        <li>
            <a href="Ingredients_manager?controllerRequest=ingredient_Requests_veiw">Approve Ingredients</a>
        </li>
        <?php endif; ?>
         <?php if ($userID != 0): ?>
       <li><a href="customer_manager?controllerRequest=show_edit_customer_veiw" >Profile</a></li> 
        <?php endif; ?>
        <?php if ($userID != 0): ?>
       <li><a href="index.php?controllerRequest=logOut" >Log Out</a></li> 
        <?php endif; ?>
       
        </ul>
        
        </nav>
     
    
