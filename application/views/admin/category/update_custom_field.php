<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-7">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_custom_field"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('category_controller/update_custom_field_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>
            <input type="hidden" name="id" value="<?php echo $field->id; ?>">
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?php foreach ($this->languages as $language): ?>
                            <div class="form-group">
                                <label><?php echo trans("field_name"); ?> (<?php echo $language->name; ?>)</label>
                                <input type="text" class="form-control" name="name_lang_<?php echo $language->id; ?>" placeholder="<?php echo trans("field_name"); ?>"
                                       value="<?php echo parse_serialized_name_array($field->name_array, $language->id, false); ?>" maxlength="255" required>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-group">
                            <label><?php echo trans("filter_key"); ?> <small>(<?= trans("filter_key_exp"); ?>)</small></label>
                            <input type="text" class="form-control" name="product_filter_key" placeholder="<?php echo trans("field_name"); ?>"
                                   value="<?= $field->product_filter_key; ?>" maxlength="255" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <label><?php echo trans('row_width'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="row_width" value="half" id="row_width_1" class="square-purple" <?php echo ($field->row_width == "half") ? "checked" : ""; ?>>
                                    <label for="row_width_1" class="option-label"><?php echo trans('half_width'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="row_width" value="full" id="row_width_2" class="square-purple" <?php echo ($field->row_width == "full") ? "checked" : ""; ?>>
                                    <label for="row_width_2" class="option-label"><?php echo trans('full_width'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <label class="control-label"><?php echo trans('required'); ?></label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="is_required" value="1" class="square-purple" <?php echo ($field->is_required == 1) ? "checked" : ""; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <label><?php echo trans('status'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="status" value="1" id="status_1" class="square-purple" <?php echo ($field->status == 1) ? "checked" : ""; ?>>
                                    <label for="status_1" class="option-label"><?php echo trans('active'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="status" value="0" id="status_2" class="square-purple" <?php echo ($field->status != 1) ? "checked" : ""; ?>>
                                    <label for="status_2" class="option-label"><?php echo trans('inactive'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('order'); ?></label>
                            <input type="number" class="form-control" name="field_order" placeholder="<?php echo trans('order'); ?>"
                                   value="<?php echo html_escape($field->field_order); ?>" min="1" max="99999" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('type'); ?></label>
                            <select class="form-control" name="field_type">
                                <option value="text" <?= $field->field_type == 'text' ? 'selected' : ''; ?>><?php echo trans('text'); ?></option>
                                <option value="textarea" <?= $field->field_type == 'textarea' ? 'selected' : ''; ?>><?php echo trans('textarea'); ?></option>
                                <option value="number" <?= $field->field_type == 'number' ? 'selected' : ''; ?>><?php echo trans('number'); ?></option>
                                <option value="checkbox" <?= $field->field_type == 'checkbox' ? 'selected' : ''; ?>><?php echo trans('checkbox'); ?></option>
                                <option value="radio_button" <?= $field->field_type == 'radio_button' ? 'selected' : ''; ?>><?php echo trans('radio_button'); ?></option>
                                <option value="dropdown" <?= $field->field_type == 'dropdown' ? 'selected' : ''; ?>><?php echo trans('dropdown'); ?></option>
                                <option value="date" <?= $field->field_type == 'date' ? 'selected' : ''; ?>><?php echo trans('date'); ?></option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                <a href="<?php echo admin_url(); ?>custom-field-options/<?php echo $field->id; ?>" class="btn btn-warning pull-right m-r-5"><i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo trans('edit_options'); ?></a>
                <a href="<?php echo admin_url(); ?>custom-fields" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
