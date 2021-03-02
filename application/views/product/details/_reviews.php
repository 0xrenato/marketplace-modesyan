<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="reviews-container">
        <div class="row">
            <div class="col-12">
                <div class="review-total">
                    <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_count; ?>)</label>
                    <?php if ($this->auth_check && $product->listing_type == "ordinary_listing" && $product->user_id != $this->auth_user->id): ?>
                        <button type="button" class="btn btn-default btn-custom btn-add-review float-right" data-toggle="modal" data-target="#rateProductModal" data-product-id="<?php echo $product->id; ?>"><?php echo trans("add_review") ?></button>
                    <?php endif; ?>
                    <?php if (!empty($reviews)):
                        $this->load->view('partials/_review_stars', ['review' => $product->rating]);
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
                                <?php if ($this->auth_check && $this->auth_user->id == $product->user_id): ?>
                                    <a href="javascript:void(0)" class="text-muted link-abuse-report" data-toggle="modal" data-target="#reportReviewModal" onclick="$('#report_review_id').val('<?= $review->id; ?>');">
                                        <?= trans("report"); ?>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php if ($this->auth_check && $this->auth_user->id == $product->user_id): ?>
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

<?php $this->load->view('partials/_modal_rate_product'); ?>