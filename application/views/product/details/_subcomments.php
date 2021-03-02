<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $subcomments = get_subcomments($parent_comment->id); ?>
<?php if (!empty($subcomments)): ?>
    <div class="row">
        <div class="col-12">
            <div class="comments">
                <ul class="comment-list">
                    <?php foreach ($subcomments as $subcomment): ?>
                        <li>
                            <div class="left">
                                <?php if (!empty($subcomment->user_slug)): ?>
                                    <a href="<?php echo generate_profile_url($subcomment->user_slug); ?>">
                                        <img src="<?php echo get_user_avatar_by_image_url($subcomment->user_avatar, $subcomment->user_type); ?>" alt="<?php echo html_escape($subcomment->name); ?>">
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo get_user_avatar_by_image_url($subcomment->user_avatar, $subcomment->user_type); ?>" alt="<?php echo html_escape($subcomment->name); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="right">
                                <div class="row-custom">
                                    <p class="username">
                                        <?php echo (!empty($subcomment->user_slug)) ? '<a href="' . generate_profile_url($subcomment->user_slug) . '">' : '';
                                        if (!empty($subcomment->user_id)):
                                            echo !empty($subcomment->user_shop_name) ? html_escape($subcomment->user_shop_name) : html_escape($subcomment->name);
                                        else:
                                            echo html_escape($subcomment->name);
                                        endif;
                                        echo (!empty($subcomment->user_slug)) ? '</a>' : ''; ?>
                                    </p>
                                </div>
                                <div class="row-custom comment">
                                    <?php echo html_escape($subcomment->comment); ?>
                                </div>
                                <div class="row-custom">
                                    <span class="date"><?php echo time_ago($subcomment->created_at); ?></span>
                                    <?php if ($this->auth_check):
                                        if ($subcomment->user_id == $this->auth_user->id || $this->auth_user->role == "admin"): ?>
                                            <a href="javascript:void(0)" class="btn-delete-comment" onclick="delete_comment('<?php echo $subcomment->id; ?>','<?php echo $subcomment->product_id; ?>','<?php echo trans("confirm_comment"); ?>');">&nbsp;<i class="icon-trash"></i>&nbsp;<?php echo trans("delete"); ?></a>
                                        <?php endif;
                                    endif; ?>

                                    <?php if ($this->auth_check):
                                        if ($subcomment->user_id != $this->auth_user->id):?>
                                            <a href="javascript:void(0)" class="text-muted link-abuse-report float-right" data-toggle="modal" data-target="#reportCommentModal" onclick="$('#report_comment_id').val('<?= $subcomment->id; ?>');">
                                                <?= trans("report"); ?>
                                            </a>
                                        <?php endif;
                                    else: ?>
                                        <a href="javascript:void(0)" class="text-muted link-abuse-report float-right" data-toggle="modal" data-target="#loginModal">
                                            <?= trans("report"); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
