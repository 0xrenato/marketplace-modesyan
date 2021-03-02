<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--print blog comments-->
<input type="hidden" value="<?php echo $comment_limit; ?>" id="blog_comment_limit">

<ul class="blog-comments">
    <?php foreach ($comments as $comment): ?>
        <li>
            <div class="left">
                <img src="<?php echo get_user_avatar_by_id($comment->user_id); ?>" class="" alt="user">
            </div>

            <div class="right">
                <p><span class="username"><?php echo html_escape($comment->name); ?></span></p>
                <p class="comment"><?php echo html_escape($comment->comment); ?></p>
                <p>
                    <span class="date"><?php echo time_ago($comment->created_at); ?></span>
                    <?php if ($this->auth_check):
                        if ($comment->user_id == $this->auth_user->id || $this->auth_user->role == "admin"): ?>
                            <a href="javascript:void(0)" class="btn-delete-comment" onclick="delete_blog_comment('<?php echo $comment->id; ?>','<?php echo $comment_post_id; ?>','<?php echo trans("confirm_comment"); ?>');">&nbsp;<i class="icon-trash"></i>&nbsp;<?php echo trans("delete"); ?></a>
                        <?php endif;
                    endif; ?>
                </p>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<?php if ($comments_count > $comment_limit): ?>
    <div id="load_comment_spinner" class="col-12 load-more-spinner">
        <div class="row">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <button class="btn-load-more" onclick="load_more_blog_comment('<?php echo $comment_post_id; ?>');">
                <?php echo trans("load_more"); ?>
            </button>
        </div>
    </div>
<?php endif; ?>


