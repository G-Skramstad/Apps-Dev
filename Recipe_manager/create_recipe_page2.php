<?php require_once '../view/header.php'; ?>
<head> <link rel="stylesheet" type="text/css" href="styles/side-by-side.css"> 
<link rel="stylesheet" type="text/css" href="styles/ingredient_adder.css"> </head>

<form action="Recipe_manager/index.php" method="POST"> 
    <input type="hidden" name="controllerRequest" value="search-ingredient" />
    <input type="hidden" name="page" value="new"/>
    <br>
    <label id="search">Search for ingredients:</label>
    <input type="text" name="ingredients_search" value="">
    <button type="submit">Search</button>
    <br>
</form>

<br>

<!-- Ingredients Loop -->
<div class="section">
    <div class="Left">
        <?php foreach ($ingredients as $ingredient) : ?>
            <form action="Recipe_manager/index.php" method="POST"> 
                <input type="hidden" name="page" value="new"/>
                <label><?php echo $ingredient->getName(); ?> - Enter amount:</label>

                <?php 
                $inList = false; 
                $ingredientAmount = '';

                foreach ($iAmounts as $iAmount) {
                    if ($iAmount->getIngredientID() == $ingredient->getId()) {
                        $ingredientAmount = $iAmount->getAmount();
                        $inList = true;
                        break; // Stop looping once found
                    }
                }
                ?>

                <input type="hidden" name="ingredient" value="<?php echo $ingredient->getName(); ?>" />
                <input type="hidden" name="ingredientID" value="<?php echo $ingredient->getId(); ?>" />
                <input type="text" name="ingredient_amount" id="ingredient_amount" value="<?php echo htmlspecialchars($ingredientAmount); ?>" />

                <?php if (!$inList): ?>
                    <input type="hidden" name="controllerRequest" value="add-ingredient" />
                    <button type="submit">Add Ingredient</button>
                <?php else: ?>
                    <input type="hidden" name="controllerRequest" value="delete-ingredient" />
                    <button type="submit">Delete Ingredient</button>
                <?php endif; ?>
            </form>
            
        <?php endforeach; ?>
    </div>

    <!-- Current Ingredients Display Section -->
    <div class="Right">
        <h3>Current Ingredients</h3>
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

<!-- Next Step Form -->
<form action="Recipe_manager/index.php" method="POST">    
    <input type="hidden" name="controllerRequest" value="createRecipe3" />
    <button type="submit" name="next">Next</button>
</form>

<?php require_once '../view/footer.php'; ?>
