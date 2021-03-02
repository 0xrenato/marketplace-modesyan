<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <form id="form_add_blog_comment">
            <input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
            <?php if (!$this->auth_check): ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name="name" id="comment_name" class="form-control form-input" placeholder="<?php echo trans("name"); ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="email" name="email" id="comment_email" class="form-control form-input" placeholder="<?php echo trans("email_address"); ?>">
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <textarea name="comment" id="comment_text" class="form-control form-input form-textarea" placeholder="<?php echo trans("comment"); ?>"></textarea>
            </div>
            <?php if (!$this->auth_check):
                generate_recaptcha();
            endif; ?>
            <div class="form-group">
                <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
            </div>
        </form>
    </div>
    <div class="col-12">
        <div id="message-comment-result" class="message-comment-result"></div>
    </div>
    <div class="col-12">
        <div id="comment-result">
            <!--include comments-->
            <?php $this->load->view("blog/_blog_comments", ["comment_post_id" => $post->id]); ?>
        </div>
    </div>
</div>
