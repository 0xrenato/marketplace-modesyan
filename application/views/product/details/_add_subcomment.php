<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form id="form_add_subcomment_<?php echo $parent_comment->id; ?>">
    <?php if (!$this->auth_check): ?>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" name="name" class="form-control form-input form-comment-name" placeholder="<?php echo trans("name"); ?>">
            </div>
            <div class="form-group col-md-6">
                <input type="email" name="email" class="form-control form-input form-comment-email" placeholder="<?php echo trans("email_address"); ?>">
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <textarea name="comment" class="form-control form-input form-textarea form-comment-text" placeholder="<?php echo trans("comment"); ?>"></textarea>
    </div>
    <?php if (!$this->auth_check):
        generate_recaptcha();
    endif; ?>
    <input type="hidden" name="product_id" value="<?php echo $parent_comment->product_id; ?>">
    <input type="hidden" name="parent_id" value="<?php echo $parent_comment->id; ?>">
    <input type="hidden" name="limit" value="<?php echo $comment_limit; ?>">
    <button type="button" class="btn btn-md btn-custom btn-submit-subcomment" data-comment-id="<?php echo $parent_comment->id; ?>"><?php echo trans("submit"); ?></button>
</form>


