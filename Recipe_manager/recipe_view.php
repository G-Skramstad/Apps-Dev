

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
<!--<section>
    <?php foreach ($comments as $comment) : 
        $commentID = $comment->getID();
        $isLiked = Comment_db::check_if_liked_comment($userID, $commentID) 
        ?>
        <div id="commentblock">
            <p><strong><?php echo htmlspecialchars($comment->getUserName()); ?></strong></p>
            <p><?php echo nl2br(htmlspecialchars($comment->getComment())); ?></p>
            <p><small>Posted on: <?php echo htmlspecialchars($comment->getDateComented()); ?></small></p>
            <p><small>likes:<?php echo $comment->getLikes() ?></small> 
            <?php if(!$isLiked): ?>
             <form action="comment_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="like_comment" /> 
              <input type="hidden" name="commentID" value="<?php echo $commentID; ?>">
              <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
              <button type="submit"> Like </button>
          </form>
            <?php endif;?> 
            <?php if ($isLiked) : ?>
              <form action="comment_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="unlike_comment" /> 
              <input type="hidden" name="commentID" value="<?php echo $commentID; ?>">
              <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
              <button type="submit"> UnLike </button>  
            <?php endif; ?>    
            
            </p>
        </div>    
    <?php endforeach; ?>     
</section>-->

<?php 
    require_once '../comment_manager/comment_view.php';
require_once '../view/footer.php'; ?>