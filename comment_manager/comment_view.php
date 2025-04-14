<?php 


if(!isset($sort) ){
    $sort = 0;
}

$comments = Comment_db::get_comments($tableType, $id,$sort,$userID);


if(!isset($error)){
    $error = "";
}
?>


<section>
    <head> <link rel="stylesheet" type="text/css" href="styles/comment.css"></head> 
        
    <div>
        <form action="comment_manager/index.php" method="POST">
           <p>leave a comment: <?php echo $error ?></p> 
       
        <input type="hidden" name="controllerRequest" value="post_comment" /> 
        <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label for="title"> title:</label>
        <input type="text" name="title" value=""> <br>
         <label for="title"> comment:</label> 
        <input type="text" name="comment" value="">
        <button type="submit"> Post </button>
         </form>
    </div>
    
    <form action="comment_manager/index.php" method="POST" id="sortForm">
        <input type="hidden" name="controllerRequest" value="sort_comment" /> 
        <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">
    <label for="sort">Sort by:</label>
    <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit()">
      <option value="newest" <?= ($sort ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
      <option value="oldest" <?= ($sort ?? '') === 'oldest' ? 'selected' : '' ?>>Oldest</option>
      <option value="most_liked" <?= ($sort ?? '') === 'most_liked' ? 'selected' : '' ?>>Most Liked</option>
      <option value="liked_first" <?= ($sort ?? '') === 'liked_first' ? 'selected' : '' ?>>Liked by Me First</option>
      <option value="username" <?= ($sort ?? '') === 'username' ? 'selected' : '' ?>>Username A-Z</option>
    </select>
  </form>
    
    <br>
    <?php foreach ($comments as $comment) : 
        $commentID = $comment->getID();
        $isLiked = Comment_db::check_if_liked_comment($userID, $commentID) 
        ?>
        <div id="commentblock">
            <form action="comment_manager/index.php" method="POST">
            <p><strong><?php echo htmlspecialchars($comment->getUserName()); ?></strong></p>
            <p><strong><?php echo htmlspecialchars($comment->getTitle()); ?></strong></p>
            <p><?php echo nl2br(htmlspecialchars($comment->getComment())); ?></p>
            <p><small>Posted on: <?php echo htmlspecialchars($comment->getDateComented()); ?></small></p>
            <p><small>likes:<?php echo $comment->getLikes() ?></small> 
            <?php if(!$isLiked): ?>
             
              <input type="hidden" name="controllerRequest" value="like_comment" /> 
              <input type="hidden" name="commentID" value="<?php echo $commentID; ?>">
              <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <button type="submit"> Like </button>
          <
            <?php endif;?> 
            <?php if ($isLiked) : ?>
              
              <input type="hidden" name="controllerRequest" value="unlike_comment" /> 
              <input type="hidden" name="commentID" value="<?php echo $commentID; ?>">
              <input type="hidden" name="TableType" value="<?php echo $tableType ?>">
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <button type="submit"> UnLike </button>  
              
            <?php endif; ?>    
            </form>
            </p>
        </div>    
    <?php endforeach; ?>     
</section>