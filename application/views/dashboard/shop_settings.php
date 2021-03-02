<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-7">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= html_escape($title); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
                <?php echo form_open("shop-settings-post"); ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("shop_name"); ?></label>
                    <input type="text" name="shop_name" class="form-control form-input" value="<?= html_escape($this->auth_user->shop_name); ?>" placeholder="<?php echo trans("shop_name"); ?>" maxlength="<?php echo $this->username_maxlength; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("shop_description"); ?></label>
                    <textarea name="about_me" class="form-control form-textarea" placeholder="<?php echo trans("shop_description"); ?>"><?= html_escape($this->auth_user->about_me); ?></textarea>
                </div>
                <?php if ($this->general_settings->rss_system == 1): ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?php echo trans('rss_feeds'); ?></label>
                            </div>
                            <div class="col-md-6 col-sm-12 col-custom-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="show_rss_feeds" value="1" id="show_rss_feeds_1" class="custom-control-input" <?= ($this->auth_user->show_rss_feeds == 1) ? 'checked' : ''; ?>>
                                    <label for="show_rss_feeds_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-custom-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="show_rss_feeds" value="0" id="show_rss_feeds_2" class="custom-control-input" <?= ($this->auth_user->show_rss_feeds != 1) ? 'checked' : ''; ?>>
                                    <label for="show_rss_feeds_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="show_rss_feeds" value="<?= $this->auth_user->show_rss_feeds; ?>">
                <?php endif; ?>

                <div class="form-group m-0">
                    <label><?= trans("shop_location"); ?></label>
                    <?php $this->load->view("partials/_location", ['countries' => $this->countries, 'country_id' => $this->auth_user->country_id, 'state_id' => $this->auth_user->state_id, 'city_id' => $this->auth_user->city_id, 'map' => true]); ?>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-sm-9 m-b-sm-15">
                            <input type="text" name="address" id="address_input" class="form-control form-input" value="<?php echo html_escape($this->auth_user->address); ?>" placeholder="<?php echo trans("address") ?>" maxlength="490">
                        </div>
                        <div class="col-sm-12 col-sm-3">
                            <input type="text" name="zip_code" id="zip_code_input" class="form-control form-input" value="<?php echo html_escape($this->auth_user->zip_code); ?>" placeholder="<?php echo trans("zip_code") ?>" maxlength="90">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div id="map-result">
                        <div class="map-container">
                            <iframe src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?= get_location($this->auth_user); ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" id="IframeMap" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" name="submit" value="update" class="btn btn-md btn-success"><?php echo trans("save_changes") ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>

    </div>
    <?php if ($this->general_settings->membership_plans_system == 1): ?>
        <div class="col-sm-5">
            <div class="box">
                <div class="box-header with-border">
                    <div class="left">
                        <h3 class="box-title"><?= trans("membership_plan"); ?></h3>
                    </div>
                </div>
                <?php if ($this->auth_user->role == "admin"): ?>
                    <div class="box-body">
                        <div class="alert alert-info alert-large">
                            <?= trans("warning_membership_admin_role"); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="box-body">
                        <?php if (!empty($user_plan)): ?>
                            <div class="form-group">
                                <label class="control-label"><?= trans("current_plan"); ?></label><br>
                                <?php $plan = null;
                                if (!empty($user_plan->plan_id)) {
                                    $plan = $this->membership_model->get_plan($user_plan->plan_id);
                                }
                                if (empty($plan)):?>
                                    <p class="label label-success label-user-plan"><?= $user_plan->plan_title; ?></p>
                                <?php else: ?>
                                    <p class="label label-success label-user-plan"><?= $this->membership_model->get_membership_plan_title($plan); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans("plan_expiration_date"); ?></label><br>
                                <?php if ($user_plan->is_unlimited_time): ?>
                                    <p class="text-success"><?= trans("unlimited"); ?></p>
                                <?php else: ?>
                                    <p><?= formatted_date($user_plan->plan_end_date); ?>&nbsp;<span class="text-danger">(<?= ucfirst(trans("days_left")); ?>:&nbsp;<?= $days_left < 0 ? 0 : $days_left; ?>)</span></p>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans("number_remaining_ads"); ?></label><br>
                                <?php if ($user_plan->is_unlimited_number_of_ads): ?>
                                    <p class="text-success"><?= trans("unlimited"); ?></p>
                                <?php else: ?>
                                    <p><?= $ads_left; ?></p>
                                <?php endif; ?>
                            </div>
                            <?php if ($this->auth_user->is_membership_plan_expired == 1): ?>
                                <div class="form-group text-center">
                                    <p class="label label-danger label-user-plan"><?= trans("msg_plan_expired"); ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="form-group text-center">
                                <a href="<?= generate_url("select_membership_plan"); ?>" class="btn btn-md btn-block btn-slate m-t-30" style="padding: 10px 12px;"><?php echo trans("renew_your_plan") ?></a>
                            </div>
                        <?php else: ?>
                            <div class="form-group">
                                <p><?= trans("do_not_have_membership_plan"); ?></p>
                            </div>
                            <div class="form-group text-center">
                                <a href="<?= generate_url("select_membership_plan"); ?>" class="btn btn-md btn-block btn-slate m-t-30" style="padding: 10px 12px;"><?php echo trans("select_your_plan") ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($user_plan) && $user_plan->is_unlimited_time != 1): ?>
                <div class="alert alert-info alert-large">
                    <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("msg_expired_plan"); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>