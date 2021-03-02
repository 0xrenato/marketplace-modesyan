<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Datepicker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datepicker/css/bootstrap-datepicker.standalone.css">
<script src="<?php echo base_url(); ?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Plyr JS-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/plyr/plyr.css">
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.polyfilled.min.js"></script>

<?php $back_url = generate_dash_url("edit_product") . "/" . $product->id; ?>
<script type="text/javascript">
    history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
    window.addEventListener('popstate', function (event) {
        window.location.assign('<?php echo $back_url; ?>');
    });
</script>

<?php if ($product->is_draft == 1): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="wizard-product">
                <h1 class="product-form-title"><?= trans("add_product"); ?></h1>
                <div class="row">
                    <div class="col-md-12 wizard-add-product">
                        <ul class="wizard-progress">
                            <li class="active" id="step_general"><strong><?= trans("general_information"); ?></strong></li>
                            <li class="active" id="step_dedails"><strong><?= trans("details"); ?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-add-product">
            <div class="box-body">
                <?php if ($product->is_draft != 1): ?>
                    <h1 class="product-form-title"><?= trans("edit_product"); ?></h1>
                <?php endif; ?>
                <div class="alert-message-lg aler-product-form">
                    <?php $this->load->view('dashboard/includes/_messages'); ?>
                </div>
                <?php if ($product->product_type == 'digital' && $product->listing_type != 'license_key'): ?>
                    <div class="row-custom">
                        <?php $this->load->view("dashboard/product/_digital_files_upload_box"); ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('edit-product-details-post', ['id' => 'form_product_details', 'class' => 'validate_price', 'class' => 'validate_terms', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <input type="hidden" name="sys_lang_id" value="<?= $this->selected_lang->id; ?>">

                <?php if ($product->product_type == 'digital'): ?>
                    <?php $this->load->view("dashboard/product/license/_license_keys", ['product' => $product, 'license_keys' => $license_keys]); ?>
                    <?php if ($product->listing_type != 'license_key'): ?>
                        <div class="form-box">
                            <div class="form-box-head">
                                <h4 class="title">
                                    <?php echo trans('multiple_sale'); ?><br>
                                </h4>
                            </div>
                            <div class="form-box-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="multiple_sale" value="1" id="multiple_sale_1" class="custom-control-input" <?= $product->multiple_sale == 1 ? 'checked' : ''; ?> required>
                                            <label for="multiple_sale_1" class="custom-control-label"><?= trans('multiple_sale_option_1'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-custom-field listing_ordinary_listing">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="multiple_sale" value="0" id="multiple_sale_2" class="custom-control-input" <?= $product->multiple_sale != 1 ? 'checked' : ''; ?> required>
                                            <label for="multiple_sale_2" class="custom-control-label"><?php echo trans('multiple_sale_option_2'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-box">
                            <div class="form-box-head">
                                <h4 class="title">
                                    <?php echo trans('files_included'); ?><br>
                                    <small><?php echo trans("files_included_ext"); ?></small>
                                </h4>
                            </div>
                            <div class="form-box-body">
                                <input type="text" name="files_included" class="form-control form-input" value="<?php echo html_escape($product->files_included); ?>" placeholder="<?php echo trans("files_included"); ?>" required maxlength="250">
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($product->listing_type == 'license_key'): ?>
                    <input type="hidden" name="multiple_sale" value="1">
                <?php endif; ?>

                <?php if (!empty($custom_fields)): ?>
                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title"><?php echo trans('details'); ?></h4>
                        </div>
                        <div class="form-box-body">
                            <div class="form-group">
                                <div class="row" id="custom_fields_container">
                                    <?php $this->load->view("dashboard/product/_custom_fields", ["custom_fields" => $custom_fields, "product" => $product]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-box">
                            <div class="row">
                                <?php if ($product->product_type != 'digital' && $product->listing_type != 'ordinary_listing'): ?>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-box-head">
                                            <h4 class="title"><?php echo trans('stock'); ?></h4>
                                        </div>
                                        <div class="form-box-body">
                                            <div class="form-group">
                                                <input type="number" name="stock" class="form-control form-input" min="0" max="999999999" value="<?php echo $product->stock; ?>" placeholder="<?php echo trans("stock"); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="stock" value="<?= $product->stock; ?>">
                                <?php endif; ?>
                                <?php if ($product->listing_type != 'ordinary_listing' && $this->product_settings->marketplace_sku == 1): ?>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="form-box-head">
                                            <h4 class="title">
                                                <?php echo trans('sku'); ?>&nbsp;<small style="width: auto;display: inline-block;margin-bottom: 0;margin-top:0;">(<?php echo trans("product_code"); ?>)</small>
                                            </h4>
                                        </div>
                                        <div class="form-box-body">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input type="text" name="sku" id="input_sku" class="form-control form-input" value="<?= $product->sku; ?>" placeholder="<?php echo trans("sku"); ?>&nbsp;(<?php echo trans("optional"); ?>)" maxlength="90">
                                                    <button type="button" class="btn btn-default btn-generate-sku" onclick="$('#input_sku').val(generateUniqueString());"><?= trans("generate"); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="sku" value="">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->load->view("dashboard/product/_edit_price"); ?>

                <?php if (($product->product_type == 'physical' && $this->product_settings->physical_demo_url == 1) || ($product->product_type == 'digital' && $this->product_settings->digital_demo_url == 1)): ?>
                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title">
                                <?php echo trans('demo_url'); ?><br>
                                <small><?php echo trans("demo_url_exp"); ?></small>
                            </h4>
                        </div>
                        <div class="form-box-body">
                            <input type="text" name="demo_url" class="form-control form-input" value="<?= html_escape($product->demo_url); ?>" placeholder="<?= trans("demo_url"); ?>" maxlength="990">
                        </div>
                    </div>
                <?php endif; ?>

                <?php $show_video_prev = false;
                $show_audio_prev = false;
                if (($product->product_type == 'physical' && $this->product_settings->physical_video_preview == 1) || ($product->product_type == 'digital' && $this->product_settings->digital_video_preview == 1)):
                    $show_video_prev = true;
                endif;
                if (($product->product_type == 'physical' && $this->product_settings->physical_audio_preview == 1) || ($product->product_type == 'digital' && $this->product_settings->digital_audio_preview == 1)):
                    $show_audio_prev = true;
                endif; ?>
                <?php if ($show_video_prev || $show_audio_prev): ?>
                    <div class="form-box form-box-preview">
                        <div class="form-box-head">
                            <h4 class="title"><?php echo trans('preview'); ?></h4>
                        </div>
                        <div class="form-box-body">
                            <div class="row">
                                <?php if ($show_video_prev): ?>
                                    <div class="col-sm-12 col-sm-6 m-b-30">
                                        <label><?php echo trans("video_preview"); ?></label>
                                        <small>(<?php echo trans("video_preview_exp"); ?>)</small>
                                        <?php $this->load->view("dashboard/product/_video_upload_box"); ?>
                                    </div>
                                <?php endif;
                                if ($show_audio_prev):?>
                                    <div class="col-sm-12 col-sm-6 m-b-30">
                                        <label><?php echo trans("audio_preview"); ?></label>
                                        <small>(<?php echo trans("audio_preview_exp"); ?>)</small>
                                        <?php $audio = $this->file_model->get_product_audio($product->id);
                                        $this->load->view("dashboard/product/_audio_upload_box", ['audio' => $audio]); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($product->listing_type == 'ordinary_listing' && $this->product_settings->classified_external_link == 1): ?>
                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title">
                                <?php echo trans('external_link'); ?><br>
                                <small><?php echo trans("external_link_exp"); ?></small>
                            </h4>
                        </div>
                        <div class="form-box-body">
                            <input type="text" name="external_link" class="form-control form-input" value="<?php echo html_escape($product->external_link); ?>" placeholder="<?php echo trans("external_link"); ?>" maxlength="990">
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($this->product_settings->marketplace_variations == 1 && $product->listing_type != 'ordinary_listing'): ?>
                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title">
                                <?php echo trans('variations'); ?>
                                <small><?php echo trans("variations_exp"); ?></small>
                            </h4>
                        </div>
                        <div class="form-box-body">
                            <div class="row">
                                <div id="response_product_variations" class="col-sm-12">
                                    <?php $this->load->view("dashboard/product/variation/_response_variations", ["product_variations" => $product_variations]); ?>
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-md btn-info btn-variation" data-toggle="modal" data-target="#addVariationModal">
                                        <?php echo trans("add_variation"); ?>
                                    </button>
                                    <button type="button" class="btn btn-md btn-secondary btn-variation" data-toggle="modal" data-target="#variationModalSelect">
                                        <?php echo trans("select_existing_variation"); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (empty($shipping_classes) && empty($shipping_delivery_times)) {
                    $shipping_status = 0;
                }
                if ($shipping_status == 1): ?>
                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title"><?php echo trans('shipping'); ?></h4>
                        </div>
                        <div class="row">
                            <?php if (!empty($shipping_classes)): ?>
                                <div class="col-sm-12 col-md-6">
                                    <label><?= trans("shipping_class"); ?>&nbsp;(<?= trans("optional"); ?>)</label>
                                    <select name="shipping_class_id" class="form-control custom-select">
                                        <option value=""><?= trans("select"); ?></option>
                                        <?php if (!empty($shipping_classes)): ?>
                                            <?php foreach ($shipping_classes as $shipping_class): ?>
                                                <option value="<?= $shipping_class->id; ?>" <?= $product->shipping_class_id == $shipping_class->id ? 'selected' : ''; ?>><?= @parse_serialized_name_array($shipping_class->name_array, $this->selected_lang->id); ?></option>
                                            <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div class="col-sm-12 col-md-6">
                                <label><?= trans('delivery_time'); ?>&nbsp;(<?= trans("optional"); ?>)</label>
                                <select name="shipping_delivery_time_id" class="form-control custom-select">
                                    <option value=""><?= trans("select"); ?></option>
                                    <?php if (!empty($shipping_delivery_times)): ?>
                                        <?php foreach ($shipping_delivery_times as $delivery_time): ?>
                                            <option value="<?= $delivery_time->id; ?>" <?= $product->shipping_delivery_time_id == $delivery_time->id ? 'selected' : ''; ?>><?= @parse_serialized_option_array($delivery_time->option_array, $this->selected_lang->id); ?></option>
                                        <?php endforeach;
                                    endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-left m-t-15 m-b-15">
        <div class="form-group">
            <div class="custom-control custom-checkbox custom-control-validate-input">
                <?php if ($product->is_draft == 1): ?>
                    <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" required>
                <?php else: ?>
                    <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" checked>
                <?php endif; ?>
                <label for="terms_conditions" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                    <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                    if (!empty($page_terms)): ?>
                        <a href="<?= generate_url($page_terms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= html_escape($page_terms->title); ?></strong></a>
                    <?php endif; ?>
                </label>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group m-t-15">
            <a href="<?php echo generate_dash_url("edit_product") . "/" . $product->id; ?>" class="btn btn-lg btn-dark pull-left"><?php echo trans("back"); ?></a>
            <?php if ($product->is_draft == 1): ?>
                <button type="submit" name="submit" value="submit" class="btn btn-lg btn-success btn-form-product-details pull-right"><?php echo trans("submit"); ?></button>
                <button type="submit" name="submit" value="save_as_draft" class="btn btn-lg btn-secondary btn-form-product-details m-r-10 pull-right"><?php echo trans("save_as_draft"); ?></button>
            <?php else: ?>
                <button type="submit" name="submit" value="save_changes" class="btn btn-lg btn-success btn-form-product-details pull-right"><?php echo trans("save_changes"); ?></button>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<?php $this->load->view("dashboard/product/variation/_form_variations"); ?>

<script>
    const player = new Plyr('#player');
    $(document).ajaxStop(function () {
        const player = new Plyr('#player');
    });
    const audio_player = new Plyr('#audio_player');
    $(document).ajaxStop(function () {
        const player = new Plyr('#audio_player');
    });
    $(window).on("load", function () {
        $(".li-dm-media-preview").css("visibility", "visible");
    });
</script>

<script>
    $.fn.datepicker.dates['en'] = {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["<?= substr(trans("monday"), 0, 3); ?>",
            "<?= substr(trans("tuesday"), 0, 3); ?>",
            "<?= substr(trans("wednesday"), 0, 3); ?>",
            "<?= substr(trans("thursday"), 0, 3); ?>",
            "<?= substr(trans("friday"), 0, 3); ?>",
            "<?= substr(trans("saturday"), 0, 3); ?>",
            "<?= substr(trans("sunday"), 0, 3); ?>"],
        months: ['<?php echo trans("january"); ?>',
            "<?= trans("february"); ?>",
            "<?= trans("march"); ?>",
            "<?= trans("april"); ?>",
            "<?= trans("may"); ?>",
            "<?= trans("june"); ?>",
            "<?= trans("july"); ?>",
            "<?= trans("august"); ?>",
            "<?= trans("september"); ?>",
            "<?= trans("october"); ?>",
            "<?= trans("november"); ?>",
            "<?= trans("december"); ?>"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear",
        format: "mm/dd/yyyy",
        titleFormat: "MM yyyy",
        weekStart: 0
    };
    $('.datepicker').datepicker({
        language: 'en'
    });

    //validate checkbox
    $(document).on("click", ".btn-form-product-details ", function () {
        $('.checkbox-options-container').each(function () {
            var field_id = $(this).attr('data-custom-field-id');
            var element = "#checkbox_options_container_" + field_id + " .required-checkbox";
            if (!$(element).is(':checked')) {
                $(element).prop('required', true);
            } else {
                $(element).prop('required', false);
            }
        });
    });
</script>
