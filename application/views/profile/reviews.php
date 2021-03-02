<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view("profile/_cover_image"); ?>
<div id="wrapper">
    <div class="container">
        <?php if (empty($user->cover_image)): ?>
            <div class="row">
                <div class="col-12">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo trans("followers"); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12">
                <div class="profile-page-top">
                    <!-- load profile details -->
                    <?php $this->load->view("profile/_profile_user_info"); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php $this->load->view("profile/_profile_tabs"); ?>
            </div>
            <div class="col-12">
                <div class="profile-tab-content">
                    <div id="user-review-result" class="user-reviews">
                        <div class="reviews-container">
                            <div class="col-12">
                                <div class="review-total">
                                    <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $user_rating->count; ?>)</label>
                                    <?php if (!empty($reviews)):
                                        $this->load->view('partials/_review_stars', ['review' => $user_rating->rating]);
                                    endif; ?>
                                </div>
                                <?php if (empty($reviews)): ?>
                                    <p class="no-comments-found"><?php echo trans("no_reviews_found"); ?></p>
                                <?php else: ?>
                                    <ul class="list-unstyled list-reviews">
                                        <?php foreach ($reviews as $review): ?>
                                            <li class="media">
                                                <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                                    <img src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                                                </a>
                                                <div class="media-body">
                                                    <?php $review_product = get_active_product($review->product_id);
                                                    if (!empty($review_product)):?>
                                                        <div class="row-custom m-b-10">
                                                            <a href="<?php echo generate_product_url_by_slug($review_product->slug); ?>"><strong><?php echo trans("product"); ?>:&nbsp;</strong><?php echo get_product_title($review_product); ?></a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="row-custom">
                                                        <?php $this->load->view('partials/_review_stars', ['review' => $review->rating]); ?>
                                                    </div>
                                                    <div class="row-custom">
                                                        <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                                            <h5 class="username"><?php echo get_shop_name_by_user_id($review->user_id); ?></h5>
                                                        </a>
                                                    </div>
                                                    <div class="row-custom">
                                                        <div class="review">
                                                            <?php echo html_escape($review->review); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row-custom">
                                                        <span class="date"><?php echo time_ago($review->created_at); ?></span>
                                                    </div>
                                                </div>
                                                <?php if ($this->auth_check && $this->auth_user->id == $user->id): ?>
                                                    <a href="javascript:void(0)" class="text-muted link-abuse-report" data-toggle="modal" data-target="#reportReviewModal" onclick="$('#report_review_id').val('<?= $review->id; ?>');">
                                                        <?= trans("report"); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 m-t-15">
                                <div class="float-right">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row-custom">
                        <!--Include banner-->
                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php if ($this->auth_check && $this->auth_user->id == $user->id): ?>
    <div class="modal fade" id="reportReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <form id="form_report_review" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("report_review"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="response_form_report_review" class="col-12"></div>
                            <div class="col-12">
                                <input type="hidden" id="report_review_id" name="id" value="">
                                <div class="form-group m-0">
                                    <label><?= trans("description"); ?></label>
                                    <textarea name="description" class="form-control form-textarea" placeholder="<?= trans("abuse_report_exp"); ?>" minlength="5" maxlength="10000" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>

