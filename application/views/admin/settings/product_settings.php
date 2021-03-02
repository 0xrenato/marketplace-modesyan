<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;margin-top: 10px;"><?php echo trans('product_settings'); ?></h3>
    </div>
    <div class="col-sm-12 message-no-margin">
        <?php $this->load->view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/product_settings_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('marketplace'); ?><br><small><?= trans("add_product_for_sale"); ?></small></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="min-height: 360px;">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('sku'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="marketplace_sku" id="marketplace_sku" value="1" class="square-purple" <?php echo ($this->product_settings->marketplace_sku == 1) ? 'checked' : ''; ?>>
                            <label for="marketplace_sku" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('variations'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="marketplace_variations" id="marketplace_variations" value="1" class="square-purple" <?php echo ($this->product_settings->marketplace_variations == 1) ? 'checked' : ''; ?>>
                            <label for="marketplace_variations" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('shipping'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="marketplace_shipping" id="marketplace_shipping" value="1" class="square-purple" <?php echo ($this->product_settings->marketplace_shipping == 1) ? 'checked' : ''; ?>>
                            <label for="marketplace_shipping" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('location'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="marketplace_product_location" id="marketplace_product_location" value="1" class="square-purple" <?php echo ($this->product_settings->marketplace_product_location == 1) ? 'checked' : ''; ?>>
                            <label for="marketplace_product_location" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="marketplace" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/product_settings_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('classified_ads'); ?><br><small><?= trans("add_product_services_listing"); ?></small></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="min-height: 360px;">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('price'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="classified_price" id="classified_price" value="1" class="square-purple" <?php echo ($this->product_settings->classified_price == 1) ? 'checked' : ''; ?>>
                            <label for="classified_price" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="classified_price_required" id="classified_price_required" value="1" class="square-purple" <?php echo ($this->product_settings->classified_price_required == 1) ? 'checked' : ''; ?>>
                            <label for="classified_price_required" class="option-label"><?php echo trans('required'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('location'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="classified_product_location" id="classified_product_location" value="1" class="square-purple" <?php echo ($this->product_settings->classified_product_location == 1) ? 'checked' : ''; ?>>
                            <label for="classified_product_location" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('external_link'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="classified_external_link" id="classified_external_link" value="1" class="square-purple" <?php echo ($this->product_settings->classified_external_link == 1) ? 'checked' : ''; ?>>
                            <label for="classified_external_link" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="classified_ads" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/product_settings_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('digital_products'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="min-height: 360px;">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('demo_url'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="digital_demo_url" id="digital_demo_url" value="1" class="square-purple" <?php echo ($this->product_settings->digital_demo_url == 1) ? 'checked' : ''; ?>>
                            <label for="digital_demo_url" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('video_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="digital_video_preview" id="digital_video_preview" value="1" class="square-purple" <?php echo ($this->product_settings->digital_video_preview == 1) ? 'checked' : ''; ?>>
                            <label for="digital_video_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('audio_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="digital_audio_preview" id="digital_audio_preview" value="1" class="square-purple" <?php echo ($this->product_settings->digital_audio_preview == 1) ? 'checked' : ''; ?>>
                            <label for="digital_audio_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('allowed_file_extensions'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input id="input_digital_allowed_file_extensions" type="text" name="digital_allowed_file_extensions" value="<?php echo str_replace('"', '', $this->product_settings->digital_allowed_file_extensions); ?>" class="form-control tags"/>
                            <small>(<?php echo trans('type_extension'); ?>&nbsp;E.g. zip, jpg, doc, pdf..)</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="digital_products" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/product_settings_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('physical_products'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="min-height: 270px;">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('demo_url'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="physical_demo_url" id="physical_demo_url" value="1" class="square-purple" <?php echo ($this->product_settings->physical_demo_url == 1) ? 'checked' : ''; ?>>
                            <label for="physical_demo_url" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('video_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="physical_video_preview" id="physical_video_preview" value="1" class="square-purple" <?php echo ($this->product_settings->physical_video_preview == 1) ? 'checked' : ''; ?>>
                            <label for="physical_video_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('audio_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="physical_audio_preview" id="physical_audio_preview" value="1" class="square-purple" <?php echo ($this->product_settings->physical_audio_preview == 1) ? 'checked' : ''; ?>>
                            <label for="physical_audio_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="physical_products" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/product_settings_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('file_upload'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="min-height: 270px;">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('max_file_size') . ' (' . trans("image") . ' )'; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" name="max_file_size_image" value="<?php echo round(($this->general_settings->max_file_size_image / 1048576), 2); ?>" min="1" class="form-control" aria-describedby="basic-addon1" required>
                                <span class="input-group-addon" id="basic-addon1">MB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('max_file_size') . ' (' . trans("video") . ' )'; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" name="max_file_size_video" value="<?php echo round(($this->general_settings->max_file_size_video / 1048576), 2); ?>" min="1" class="form-control" aria-describedby="basic-addon2" required>
                                <span class="input-group-addon" id="basic-addon2">MB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('max_file_size') . ' (' . trans("audio") . ' )'; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" name="max_file_size_audio" value="<?php echo round(($this->general_settings->max_file_size_audio / 1048576), 2); ?>" min="1" class="form-control" aria-describedby="basic-addon3" required>
                                <span class="input-group-addon" id="basic-addon3">MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="file_upload" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<style>
    .col-sm-12 label {
        margin-left: 10px;
        font-weight: 400 !important;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    #input_digital_allowed_file_extensions_tag {
        width: auto !important;
    }
</style>

<script>
    $(function () {
        $('#input_digital_allowed_file_extensions').tagsInput({width: 'auto', 'defaultText': ''});
    });
</script>
