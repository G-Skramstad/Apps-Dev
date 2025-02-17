
<?php require_once '../view/header.php'; ?>

<head> <link rel="stylesheet" type="text/css" href="styles/side-by-side.css"> </head>

<br><!-- comment -->

<h1> enter your Ingredient information </h1>
<form method="POST" action="ingredient_manager/index.php">
   <input type="hidden" name="controllerRequest" value="requestIngredient">  
    <!-- Add the code-->
    <label>Name: </label> <input type="text" name="name" >
    <br>
    <label>Ingredient Type: </label> 
    <select>
        <?php foreach ($ingredientTypes as $ingredientType) :?>
        <option value="<?php echo $ingredientType->getId(); ?>"><?php echo $ingredientType->getName(); ?></option>
        
        <?php endforeach;?>
    </select>
    <br>
    <label>Flavor notes: </label> <input type="text" name="description">
    <br>
    <label>Uses: </label> <input type="text" name="description">
    <br>
    <label>Image Url: </label> <input type="text" name="description">
    <br>
    <label></label>
    <input type="submit" value="request ingredient">
</form>




<?php require_once '../view/footer.php'; ?>