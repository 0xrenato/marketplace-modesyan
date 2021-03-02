<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("edit_plan"); ?></h3>
            </div>
            <?php echo form_open('membership_controller/edit_plan_post'); ?>
            <input type="hidden" name="id" value="<?= $plan->id; ?>">
            <div class="box-body">
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("title"); ?></label>
                    <?php foreach ($this->languages as $language): ?>
                        <input type="text" class="form-control m-b-5" name="title_<?php echo $language->id; ?>" value="<?= get_membership_plan_name($plan->title_array, $language->id); ?>" placeholder="<?= $language->name; ?>" maxlength="255" required>
                    <?php endforeach; ?>
                </div>

                <div class="form-inline option-plan-type m-b-15">
                    <label class="control-label m-b-5"><?= trans("number_of_ads"); ?></label>
                    <div>
                        <div class="form-group form-group-number-of-ads" <?= $plan->is_unlimited_number_of_ads == 1 ? 'style="display:none;"' : ''; ?>>
                            <input type="number" class="form-control form-input m-r-10" name="number_of_ads" value="<?= !empty($plan->number_of_ads) ? $plan->number_of_ads : ''; ?>" min="1" max="999999999" placeholder="E.g: 10" <?= empty($plan->is_unlimited_number_of_ads) ? 'required' : ''; ?> style="min-width: 400px; max-width: 100%;">
                        </div>
                        <div class="form-group">
                            <div class="col-custom-option">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_unlimited_number_of_ads" id="checkbox_is_unlimited_number_of_ads" value="1" class="custom-control-input" <?= $plan->is_unlimited_number_of_ads == 1 ? 'checked' : ''; ?>>
                                    <label for="checkbox_is_unlimited_number_of_ads" class="custom-control-label"><?php echo trans("unlimited"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-inline m-b-15">
                    <label class="control-label m-b-5"><?= trans("duration") . " (" . trans("time_limit_for_plan") . ")"; ?></label>
                    <div>
                        <div class="form-group form-group-duration" <?= $plan->is_unlimited_time == 1 ? 'style="display:none;"' : ''; ?>>
                            <input type="number" name="number_of_days" value="<?= !empty($plan->number_of_days) ? $plan->number_of_days : ''; ?>" class="form-control form-input m-r-10" min="1" max="999999999" placeholder="<?= trans("number_of_days") ?>&nbsp;&nbsp;(E.g: 30)" <?= empty($plan->is_unlimited_time) ? 'required' : ''; ?> style="min-width: 400px; max-width: 100%;">
                        </div>
                        <div class="form-group">
                            <div class="col-custom-option">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_unlimited_time" id="checkbox_is_unlimited_time" value="1" class="custom-control-input" <?= $plan->is_unlimited_time == 1 ? 'checked' : ''; ?>>
                                    <label for="checkbox_is_unlimited_time" class="custom-control-label"><?php echo trans("unlimited"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-inline m-b-15">
                    <label class="control-label m-b-5"><?php echo trans("price"); ?></label>
                    <div>
                        <div class="form-group form-group-price" <?= $plan->is_free == 1 ? 'style="display:none;"' : ''; ?>>
                            <div class="input-group" style="min-width: 410px; max-width: 100%; padding-right: 10px;">
                                <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                <input type="text" name="price" value="<?= !empty($plan->price) ? get_price($plan->price, 'input') : ''; ?>" class="form-control form-input price-input validate-price-input" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= empty($plan->is_free) ? 'required' : ''; ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-custom-option">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_free" id="checkbox_free" value="1" class="custom-control-input" <?= $plan->is_free == 1 ? 'checked' : ''; ?>>
                                    <label for="checkbox_free" class="custom-control-label"><?php echo trans("free"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("order"); ?></label>
                    <input type="number" class="form-control" name="plan_order" value="<?= $plan->plan_order; ?>" min="1" max="99999" placeholder="<?php echo trans("order"); ?>" required>
                </div>
                <div class="form-group">
                    <div class="col-custom-option">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_popular" id="checkbox_is_popular" value="1" class="custom-control-input"  <?= $plan->is_popular == 1 ? 'checked' : ''; ?>>
                            <label for="checkbox_is_popular" class="custom-control-label"><?php echo trans("popular"); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("features"); ?></label>
                    <hr style="margin-top: 5px;margin-bottom: 5px;">
                    <div class="membership-plans-container">
                        <?php $main_features = get_membership_plan_features($plan->features_array, $this->selected_lang->id);
                        if (!empty($main_features)):
                            $index = 0;
                            foreach ($main_features as $feature): ?>
                                <div class="feature">
                                    <p class="m-b-5"><?= trans("feature"); ?>
                                        <?php if ($index != 0): ?>
                                            <span class="btn btn-xs btn-danger btn-delete-membership-feature m-l-5"><i class="fa fa-times"></i></span>
                                        <?php endif; ?>
                                    </p>
                                    <?php foreach ($this->languages as $language):
                                        $lang_features = get_membership_plan_features($plan->features_array, $language->id); ?>
                                        <input type="text" name="feature_<?= $language->id; ?>[]" value="<?= !empty($lang_features[$index]) ? $lang_features[$index] : ''; ?>" class="form-control m-b-5" placeholder="<?= $language->name; ?>" required>
                                    <?php endforeach; ?>
                                    <?php $index++; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="feature">
                                <p class="m-b-5"><?= trans("feature"); ?></p>
                                <?php foreach ($this->languages as $language): ?>
                                    <input type="text" name="feature_<?= $language->id; ?>[]" class="form-control m-b-5" placeholder="<?= $language->name; ?>" required>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-sm btn-success" onclick="add_membership_feature();">
                                <i class="fa fa-plus"></i>&nbsp;<?= trans("add_feature"); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a href="<?= admin_url(); ?>membership-plans" class="btn btn-danger pull-left"><?= trans("back"); ?></a>
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans("save_changes"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
    function add_membership_feature() {
        var feature = '<div class="feature">\n';
        feature += '<p class="m-b-5"><?= trans("feature"); ?><span class="btn btn-xs btn-danger btn-delete-membership-feature m-l-5"><i class="fa fa-times"></i></span></p>\n';
        <?php foreach ($this->languages as $language): ?>
        feature += '<input type="text" name="feature_<?= $language->id; ?>[]" class="form-control m-b-5" placeholder="<?= $language->name; ?>" required>';
        <?php endforeach; ?>
        feature += '</div>';
        $('.membership-plans-container').append(feature);
    }

    $(document).on('click', '.btn-delete-membership-feature', function () {
        $(this).closest('.feature').remove();
    });
    $(document).on('change', '#checkbox_is_unlimited_time', function () {
        if ($(this).is(':checked')) {
            $(".form-group-duration").hide();
            $(".form-group-duration .form-input").prop('required', false);
        } else {
            $(".form-group-duration").show();
            $(".form-group-duration .form-input").prop('required', true);
        }
    });
    $(document).on('change', '#checkbox_is_unlimited_number_of_ads', function () {
        if ($(this).is(':checked')) {
            $(".form-group-number-of-ads").hide();
            $(".form-group-number-of-ads .form-input").prop('required', false);
        } else {
            $(".form-group-number-of-ads").show();
            $(".form-group-number-of-ads .form-input").prop('required', true);
        }
    });
    $(document).on('change', '#checkbox_is_unlimited_sum_of_prices', function () {
        if ($(this).is(':checked')) {
            $(".form-group-sum-of-prices").hide();
            $(".form-group-sum-of-prices .form-input").prop('required', false);
        } else {
            $(".form-group-sum-of-prices").show();
            $(".form-group-sum-of-prices .form-input").prop('required', true);
        }
    });
    $(document).on('change', '#checkbox_free', function () {
        if ($(this).is(':checked')) {
            $(".form-group-price").hide();
            $(".form-group-price .form-input").prop('required', false);
        } else {
            $(".form-group-price").show();
            $(".form-group-price .form-input").prop('required', true);
        }
    });
</script>
