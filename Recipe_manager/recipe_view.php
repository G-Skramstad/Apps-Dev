

<?php require_once '../view/header.php'; ?>
<head> <link rel="stylesheet" type="text/css" href="styles/side-by-side.css"> </head>


<h1></h1>

<div class="section">
    <div class="Left">
       
   <input type="hidden" name="controllerRequest" value="addRecipe">  

    
   <h1><?php echo $recipe->getName();?></h1>

        
<h3><?php echo $recipe-> getDescription(); ?></h3>
<p><?php echo $recipe-> getInstructions(); ?></p>

    </div>

    <!-- Current Ingredients Display Section -->
    <div class="Right">
        
        <h3>Ingredients:</h3>
        <ul>
            <?php foreach ($ingredients as $ingredient): ?>
                <li><?php 
                echo $ingredient->getIngredientName(); ?> - 
                    <?php echo $ingredient->getAmount(); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<br>


<?php require_once '../view/footer.php'; ?>