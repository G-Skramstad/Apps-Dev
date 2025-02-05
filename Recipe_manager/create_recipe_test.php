
<?php require_once '../view/header.php'; ?>

<form action="Recipe_manager/index.php" method="POST"> 
        
    <input type="hidden" name="controllerRequest" value="search-ingredient" />
        <!--need if  on index to determin witch button was pressed -->
        
       
    <br>
    <label id="search">Search for ingredients:</label>
     <input type="text" name="ingredients_search" value="">
            
            
    <button type="submit">search</button>
     <br>
</form>
        
            
<br>
        <!-- add $ingredients loop  -->
<?php foreach ($ingredients as $ingredient) : ?>
    <form action="Recipe_manager/index.php" method="POST"> 
        <label><?php echo $ingredient->getName(); ?>     enter amount:</label>
        
        <input type="hidden" name="ingredient" value="<?php echo $ingredient->getId();  
        $inList = false;
        ?>" />
        
        <input type="text" name = "ingredient_amount"
               <?php 
               foreach ($iAmounts as $iAmount){
                  if( $iAmount->getIngredientID() == $ingredient->getId()){
                      echo 'value="'.$iAmount->getAmount().'"';
                      $inList = true;
                  }
               }
               
               ?> 
               >  
         <?php if (!$inList): ?>
        <input type="hidden" name="controllerRequest" value="add-ingredient" />
        <button type="submit"> Add Ingredient </button>
        <?php endif ?>
        <?php if ($inList): ?>
        <input type="hidden" name="controllerRequest" value="delete-ingredient" />
        <button type="submit"> Delete Ingredient </button>
        <?php endif ?>
        
    </form>
        <br>
<?php endforeach; ?>
        
<br>
        
<form action="Recipe_manager/index.php" method="POST">    
    <input type="hidden" name="controllerRequest" value="createRecipe3" />
    
    <button type="submit" name="next">next</button>
   
        
</form>
     
    
    



<?php require_once '../view/footer.php'; ?>