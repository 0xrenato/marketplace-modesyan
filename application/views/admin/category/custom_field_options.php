<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 form-header">
        <h1 class="form-title"><?php echo trans('custom_field_options'); ?></h1>
    </div>
</div>
<div class="callout" style="margin-top: 10px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
    <h4><?php echo trans("custom_field"); ?></h4>
    <p><?php echo trans('field_name'); ?>:&nbsp;<strong><?= parse_serialized_name_array($field->name_array, $this->selected_lang->id); ?></strong></p>
    <p>
        <?php echo trans('type'); ?>:&nbsp;
        <strong>
            <?php echo trans($field->field_type); ?>
        </strong>
    </p>
</div>

<div class="row">
    <?php if ($field->field_type == "checkbox" || $field->field_type == "radio_button" || $field->field_type == "dropdown"): ?>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans("options"); ?></h3>
                </div>
                <div class="box-body">
                    <?php if (!empty($options)): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="custom-field-options" style="max-height: 600px; overflow: auto">
                                        <?php
                                        $count = 1;
                                        foreach ($options as $option): ?>
                                            <div class="field-option-item">
                                                <?php echo form_open('category_controller/update_custom_field_option_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>
                                                <input type="hidden" name="id" value="<?= $option->id; ?>">
                                                <div class="option-title">
                                                    <strong><?php echo trans("option") . " " . $count; ?></strong>
                                                </div>
                                                <?php if (!empty($this->languages)):
                                                    foreach ($this->languages as $language):
                                                        $name_key = "option_name_" . $language->id; ?>
                                                        <p>
                                                            <input type='text' class="form-control" name="option_lang_<?= $language->id; ?>" value="<?= $option->$name_key; ?>" placeholder="<?= trans("option"); ?> (<?= $language->name; ?>)" style="width: 100%;padding: 0 5px; bottom: 0 !important;box-shadow: none !important;height: 26px;" required>
                                                        </p>
                                                    <?php endforeach;
                                                endif; ?>
                                                <div>
                                                    <button type="button" class="btn btn-xs btn-danger pull-right" onclick='delete_custom_field_option("<?php echo trans("confirm_delete"); ?>","<?= $option->id; ?>");'><?php echo trans("delete"); ?></button>
                                                    <button type="submit" class="btn btn-xs btn-success pull-right m-r-5"><?php echo trans("save_changes"); ?></button>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>
                                            <?php $count++;
                                        endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('category_controller/add_custom_field_option_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>
                    <input type="hidden" name="field_id" value="<?= $field->id; ?>">
                    <div class="form-group m-b-10">
                        <label><?= trans("add_option"); ?></label>
                        <?php if (!empty($this->languages)):
                            foreach ($this->languages as $language):?>
                                <input type="text" class="form-control option-input m-b-5" name="option_lang_<?= $language->id; ?>" placeholder="<?= trans("option"); ?> (<?= $language->name; ?>)" required>
                            <?php endforeach;
                        endif; ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_option'); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-sm-6">
        <div class="box box-primary" style="min-height: 252px;">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("categories"); ?></h3>
                <small>(<?php echo trans("show_under_these_categories"); ?>)</small>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open_multipart('category_controller/add_category_to_custom_field', ['onkeypress' => 'return event.keyCode != 13;']); ?>
            <input type="hidden" name="field_id" value="<?php echo $field->id; ?>">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("category"); ?></label>
                    <select id="categories" name="category_id[]" class="form-control" onchange="get_subcategories(this.value, 0);" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($parent_categories as $item): ?>
                            <option value="<?php echo html_escape($item->id); ?>"><?php echo category_name($item); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="category_select_container"></div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary"><?php echo trans('select_category'); ?></button>
                </div>

                <div class="row m-t-15">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped" role="grid">
                            <tbody>
                            <?php if (!empty($field_categories)):
                                foreach ($field_categories as $item):
                                    if (!empty($item)):
                                        $category = get_category_by_id($item->category_id);
                                        $categories_tree = get_parent_categories_tree($category, false);
                                        if (!empty($categories_tree)):?>
                                            <tr>
                                                <td>
                                                    <?php $count = 0;
                                                    foreach ($categories_tree as $item_tree):
                                                        $item_category = get_category_by_id($item_tree->id);
                                                        if (!empty($item_category)):
                                                            if ($count == 0) {
                                                                echo category_name($item_category);
                                                            } else {
                                                                echo " / " . category_name($item_category);
                                                            }
                                                        endif;
                                                        $count++;
                                                    endforeach; ?>
                                                    <button type="button" class="btn btn-xs btn-danger pull-right" onclick="delete_custom_field_category('<?php echo trans("confirm_delete"); ?>',<?php echo $field->id; ?>,<?php echo $item_category->id; ?>);"><?php echo trans("delete"); ?></button>
                                                </td>
                                            </tr>
                                        <?php endif;
                                    endif;
                                endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>

        <?php if ($field->field_type == "checkbox" || $field->field_type == "radio_button" || $field->field_type == "dropdown"): ?>
            <!-- /.box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('settings'); ?></h3>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <?php echo form_open('category_controller/custom_field_settings_post'); ?>
                <input type="hidden" name="field_id" value="<?= $field->id; ?>">
                <div class="box-body">
                    <!-- include message block -->
                    <?php if (!empty($this->session->flashdata('msg_settings'))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>

                    <div class="form-group m-b-30">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?php echo trans("sort_options"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <input type="radio" name="sort_options" value="date" id="by_date_1" class="square-purple" <?= ($field->sort_options == 'date') ? 'checked' : ''; ?>>
                                <label for="by_date_1" class="option-label"><?php echo trans('by_date'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <input type="radio" name="sort_options" value="date_desc" id="by_date_desc_1" class="square-purple" <?= ($field->sort_options == 'date_desc') ? 'checked' : ''; ?>>
                                <label for="by_date_desc_1" class="option-label"><?php echo trans('by_date'); ?>&nbsp;(DESC)</label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <input type="radio" name="sort_options" value="alphabetically" id="alphabetically_1" class="square-purple" <?= ($field->sort_options == 'alphabetically') ? 'checked' : ''; ?>>
                                <label for="alphabetically_1" class="option-label"><?php echo trans('alphabetically'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function get_subcategories(category_id, data_select_id) {
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('.subcategory-select').each(function () {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<select class="form-control subcategory-select" data-select-id="' + new_data_select_id + '" name="category_id[]" onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
                '<option value=""><?php echo trans('none'); ?></option>';
            for (i = 0; i < subcategories.length; i++) {
                select_tag += '<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>';
            }
            select_tag += '</select>';
            $('#category_select_container').append(select_tag);
        }
    }

    function get_subcategories_array(category_id) {
        var categories_array = <?php echo get_categories_json($this->selected_lang->id); ?>;
        var subcategories_array = [];
        for (i = 0; i < categories_array.length; i++) {
            if (categories_array[i].parent_id == category_id) {
                subcategories_array.push(categories_array[i]);
            }
        }
        return subcategories_array;
    }
</script>
