<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
                <h1 class="page-title page-title-product m-b-15"><?= html_escape($title); ?></h1>
                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <p class="start-selling-description text-muted"><?= trans("select_your_plan_exp"); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <!-- include message block -->
                                    <?php $this->load->view('product/_messages'); ?>
                                </div>
                            </div>
                            <?php echo form_open('renew-membership-plan-post'); ?>
                            <?php if (!empty($membership_plans)): ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="price-box-container">
                                            <?php foreach ($membership_plans as $plan):
                                                $valid_plan = 1;
                                                if ($plan->is_unlimited_number_of_ads != 1 && $user_ads_count > $plan->number_of_ads) {
                                                    $valid_plan = 0;
                                                }
                                                if ($plan->is_free == 1 && $this->auth_user->is_used_free_plan == 1) {
                                                    $valid_plan = 0;
                                                } ?>
                                                <div class="price-box">
                                                    <?php if ($plan->is_popular == 1): ?>
                                                        <div class="ribbon ribbon-top-right"><span><?= trans("popular"); ?></span></div>
                                                    <?php endif; ?>
                                                    <div class="price-box-inner">
                                                        <div class="pricing-name text-center">
                                                            <h4 class="name font-600"><?= get_membership_plan_name($plan->title_array, $this->selected_lang->id); ?></h4>
                                                        </div>
                                                        <div class="plan-price text-center">
                                                            <h3><strong class="price font-600">
                                                                    <?php if ($plan->price == 0):
                                                                        echo trans("free");
                                                                    else:
                                                                        echo price_formatted($plan->price, $this->payment_settings->default_currency);
                                                                    endif; ?>
                                                                </strong>
                                                            </h3>
                                                        </div>
                                                        <div class="price-features">
                                                            <?php $features = get_membership_plan_features($plan->features_array, $this->selected_lang->id);
                                                            if (!empty($features)):
                                                                foreach ($features as $feature):?>
                                                                    <p>
                                                                        <i class="icon-check-thin"></i>
                                                                        <?= html_escape($feature); ?>
                                                                    </p>
                                                                <?php endforeach;
                                                            endif; ?>
                                                        </div>
                                                        <div class="text-center btn-plan-pricing-container">
                                                            <?php if ($valid_plan == 1):
                                                                if ($request_type == "renew"): ?>
                                                                    <button type="submit" name="plan_id" value="<?= $plan->id; ?>" class="btn btn-md btn-pricing-table"><?= trans("choose_plan"); ?></button>
                                                                <?php elseif ($request_type == "new"): ?>
                                                                    <a href="<?= generate_url('start_selling'); ?>?plan=<?= $plan->id; ?>" class="btn btn-md btn-pricing-table"><?= trans("choose_plan"); ?></a>
                                                                <?php endif;
                                                            else: ?>
                                                                <button type="button" class="btn btn-md btn-pricing-table btn-pricing-table-disabled"><?= trans("choose_plan"); ?></button>
                                                                <?php if ($plan->is_free == 1 && $this->auth_user->is_used_free_plan == 1): ?>
                                                                    <span class="warning-pricing-table-plan text-muted"><?= trans("warning_plan_used"); ?></span>
                                                                <?php else: ?>
                                                                    <span class="warning-pricing-table-plan text-muted"><?= trans("warning_cannot_choose_plan"); ?></span>
                                                                <?php endif;
                                                            endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->
