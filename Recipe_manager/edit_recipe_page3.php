<?php require_once '../view/header.php'; ?>
<head> <link rel="stylesheet" type="text/css" href="styles/side-by-side.css"> </head>

<h1>Enter the instruction to Your Recipe</h1>


<div class="section">
    <div class="Left">
        <form method="POST" action="recipe_manager/index.php">
   <input type="hidden" name="controllerRequest" value="editRecipe">  

    
    <label for="instructions"> instructions </label>

        
    <textarea id="instructions" name="instructions" rows="30" cols="65">
            <?php echo $instructions; ?>
test
    </textarea>
        
        <br>
        <br><!-- comment -->
        
        <button type="submit">Edit Recipe</button>
        </form>
    </div>

    <!-- Current Ingredients Display Section -->
    <div class="Right">
        <h3>Name: <?php echo $recipeName?></h3>
        <h3>Description: <?php echo $recipeDescription?></h3>
        <h3>Ingredients:</h3>
        <ul>
            <?php foreach ($iAmounts as $iAmount): ?>
                <li><?php 
                echo $iAmount->getIngredientName(); ?> - 
                    <?php echo $iAmount->getAmount(); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<br>





<?php require_once '../view/footer.php'; ?>