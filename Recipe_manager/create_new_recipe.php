<?php require_once '../view/header.php'; ?>
<br>

    
    
    <form action="Recipe_manager/index.php" method="POST"> 
        
        <input type="hidden" name="controllerRequest" value="addRecipe" />
        <!--need if  on index to determin witch button was pressed -->
        
        <label for="name"> Name</label>
        <input type="text" name="name">

        <br>
        <label for="description"> Description</label>
        <input type="text" name="description">

        <br>
            <label id="search">Search for ingredients:</label>
            <input type="text" name="ingredients_search" value="">
            
            
            <input type="submit" value="Search"><br>
        
            <div>
        <!-- add $ingredients loop  -->
            <?php foreach ($ingredients as $ingredient) : ?>
        <label><?php echo $ingredient->getName(); ?></label>
        <input type="checkbox" name="<?php echo $ingredient->getName(); ?>"> 
        <label>amount</label>
        <input type="text" name = "<?php echo $ingredient->getName(); ?> amount">  
        
        <br>
            <?php endforeach; ?>
        </div>
            <br>
        
        <!-- end loop  -->
        
        <label for="instructions"> instructions </label>

        
        <textarea id="instructions" name="instructions" rows="4" cols="50"></textarea>
        
        <br>
        
        <button type="submit">submit</button>
        
        
        
       
        
    </form>
     
    
    



<?php require_once '../view/footer.php'; ?>

