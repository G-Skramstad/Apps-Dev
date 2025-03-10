<?php 

$comments = Comment_db::get_comments($tableType, $id);


?>


<section>
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
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <button type="submit"> Like </button>
          </form>
            <?php endif;?> 
            <?php if ($isLiked) : ?>
              <form action="comment_manager/index.php" method="POST">
              <input type="hidden" name="controllerRequest" value="unlike_comment" /> 
              <input type="hidden" name="commentID" value="<?php echo $commentID; ?>">
              <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <button type="submit"> UnLike </button>  
            <?php endif; ?>    
            
            </p>
        </div>    
    <?php endforeach; ?>     
</section>