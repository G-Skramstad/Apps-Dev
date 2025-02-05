
<?php require_once '../view/header.php'; ?>

<form action="Recipe_manager/index.php" method="POST"> 
        
        <input type="hidden" name="controllerRequest" value="createRecipe3" />
        <!--need if  on index to determin witch button was pressed -->
        
       
        <br>
            <label id="search">Search for ingredients:</label>
            <input type="text" name="ingredients_search" value="">
            
            
            <button type="submit">search</button>
            <br>
        
            <div>
                <br>
        <!-- add $ingredients loop  -->
            <?php foreach ($ingredients as $ingredient) : ?>
        <label><?php echo $ingredient->getName(); ?></label>
        <input type="checkbox" name="<?php echo $ingredient->getName(); ?>"
               <?php 
               foreach ($iAmounts as $iAmount){
                  if( $iAmount->getIngredientID() == $ingredient->getId()){
                      echo 'checked';
                  }
               }
               
               ?>
               > 
        <label>amount</label>
        <input type="text" name = "<?php echo $ingredient->getName(); ?> amount"
               <?php 
               foreach ($iAmounts as $iAmount){
                  if( $iAmount->getIngredientID() == $ingredient->getId()){
                      echo 'value="' + $iAmount->getAmount() + '"';
                  }
               }
               
               ?> value=""
               >  
        
        <br>
            <?php endforeach; ?>
        </div>
            <br>
        
        
        
        <button type="submit" name="next">next</button>
        
        
        
       
        
    </form>
     
    
    



<?php require_once '../view/footer.php'; ?>