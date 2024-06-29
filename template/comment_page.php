<div class="comments-section pt-3" id="commentsSection_<?php echo $post['IDpost']; ?>" style="display: none;">
    <div class="comments-list" id="comments_<?php echo $post['IDpost']; ?>" style="max-height: 300px; overflow-y: scroll;"></div>
    <form method="post" class="comment-form text-center" onsubmit="return false;" style="position: sticky; ">
        <label for="addComment_<?php echo $post['IDpost']; ?>" hidden>Write Comment</label>
        <input type="text" name="comment" class="form-control" id="addComment_<?php echo $post['IDpost']; ?>" data-parent-id="" placeholder="Aggiungi un commento..."/>
        <button type="submit" class="btn btn-primary mt-3" style="border-radius: 25px" onclick="postComment(<?php echo $post['IDpost']; ?>)">Pubblica</button>
    </form>
</div>
