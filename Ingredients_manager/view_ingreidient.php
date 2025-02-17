
<?php require_once '../view/header.php'; ?>

<head> <link rel="stylesheet" type="text/css" href="styles/side-by-side.css"> </head>

<div class="section">
    <div class="Right">
        <img src="<?php echo $ingredient->getImage();?>" width="100" alt="No image Provided"/>
    </div>
    
    <div class="Left">
        <h1><?php echo $ingredient->getName(); ?></h1>
        
    <p>
        flavor notes: <?php echo $ingredient->getFlavorNotes();?>
    </p>
    <hr>
    <p>
        uses: <?php echo $ingredient->getUses();?> 
    </p>
    <hr>
    <p>
        Ingredient Type: <?php echo $ingredient->getIngredientType();?>
    </p>
    </div>
   
           
    
</div>




<?php require_once '../view/footer.php'; ?>