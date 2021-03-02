<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!empty($custom_fields)):
    foreach ($custom_fields as $custom_field):
        if (!empty($custom_field)):
            $custom_field_name = parse_serialized_name_array($custom_field->name_array, $this->selected_lang->id);
            if ($custom_field->field_type == "text"):
                $input_value = $this->field_model->get_product_custom_field_input_value($custom_field->id, $product->id); ?>
                <div class="col-sm-12 <?= ($custom_field->row_width == "half") ? "col-sm-6" : "col-sm-12"; ?> col-custom-field">
                    <label><?= $custom_field_name; ?></label>
                    <input type="text" name="field_<?= $custom_field->id; ?>" class="form-control form-input" value="<?= @html_escape($input_value); ?>" placeholder="<?= $custom_field_name; ?>" <?= $custom_field->is_required == 1 ? 'required' : ''; ?>>
                </div>
            <?php elseif ($custom_field->field_type == "number"):
                $input_value = $this->field_model->get_product_custom_field_input_value($custom_field->id, $product->id); ?>
                <div class="col-sm-12 <?= $custom_field->row_width == "half" ? "col-sm-6" : "col-sm-12"; ?> col-custom-field">
                    <label><?= $custom_field_name; ?></label>
                    <input type="number" name="field_<?= $custom_field->id; ?>" class="form-control form-input" value="<?= @html_escape($input_value); ?>" placeholder="<?= $custom_field_name; ?>" min="0" max="999999999" <?= $custom_field->is_required == 1 ? 'required' : ''; ?>>
                </div>
            <?php elseif ($custom_field->field_type == "textarea"):
                $input_value = $this->field_model->get_product_custom_field_input_value($custom_field->id, $product->id); ?>
                <div class="col-sm-12 <?= $custom_field->row_width == "half" ? "col-sm-6" : "col-sm-12"; ?> col-custom-field">
                    <label><?= $custom_field_name; ?></label>
                    <textarea class="form-control form-input custom-field-input" name="field_<?= $custom_field->id; ?>" placeholder="<?= $custom_field_name; ?>" <?= $custom_field->is_required == 1 ? 'required' : ''; ?>><?= @html_escape($input_value); ?></textarea>
                </div>
            <?php elseif ($custom_field->field_type == "date"):
                $input_value = $this->field_model->get_product_custom_field_input_value($custom_field->id, $product->id); ?>
                <div class="col-sm-12 <?= ($custom_field->row_width == "half") ? "col-sm-6" : "col-sm-12"; ?> col-custom-field">
                    <label><?= $custom_field_name; ?></label>
                    <div class="input-group date input-group-datepicker" data-provide="datepicker">
                        <input type="text" name="field_<?= $custom_field->id; ?>" value="<?= @html_escape($input_value); ?>" class="datepicker form-control form-input" placeholder="<?= $custom_field_name; ?>" <?= $custom_field->is_required == 1 ? 'required' : ''; ?>>
                        <div class="input-group-append input-group-addon cursor-pointer">
                            <span class="input-group-text input-group-text-date"><i class="icon-calendar"></i> </span>
                        </div>
                    </div>
                </div>
            <?php elseif ($custom_field->field_type == "dropdown"): ?>
                <div class="col-sm-12 <?= $custom_field->row_width == "half" ? "col-sm-6" : "col-sm-12"; ?> col-custom-field">
                    <label><?= $custom_field_name; ?></label>
                    <select name="field_<?= $custom_field->id; ?>" class="form-control custom-select" <?= ($custom_field->is_required == 1) ? 'required' : ''; ?>>
                        <option value=""><?= trans('select_option'); ?></option>
                        <?php $field_options = $this->field_model->get_field_options($custom_field, $this->selected_lang->id);
                        $field_values = $this->field_model->get_product_custom_field_values($custom_field->id, $product->id, $this->selected_lang->id);
                        $selected_option_ids = get_array_column_values($field_values, 'selected_option_id');
                        if (!empty($field_options)):
                            foreach ($field_options as $field_option):?>
                                <option value="<?= $field_option->id; ?>" <?= is_value_in_array($field_option->id, $selected_option_ids) ? 'selected' : ''; ?>><?= get_custom_field_option_name($field_option); ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
            <?php elseif ($custom_field->field_type == "radio_button"): ?>
                <div class="col-sm-12 <?= $custom_field->row_width == "half" ? "col-sm-6" : "col-sm-12"; ?> col-custom-field">
                    <label><?= $custom_field_name; ?></label>
                    <div class="row">
                        <?php $field_options = $this->field_model->get_field_options($custom_field, $this->selected_lang->id);
                        $field_values = $this->field_model->get_product_custom_field_values($custom_field->id, $product->id, $this->selected_lang->id);
                        $selected_option_ids = get_array_column_values($field_values, 'selected_option_id');
                        if (!empty($field_options)):
                            foreach ($field_options as $field_option): ?>
                                <div class="col-sm-12 col-sm-3 col-custom-option">
                                    <div class="custom-control custom-radio custom-control-validate-input label_validate_field_<?= $custom_field->id; ?>">
                                        <input type="radio" class="custom-control-input" id="form_radio_<?= $field_option->id; ?>" name="field_<?= $custom_field->id; ?>"
                                               value="<?= $field_option->id; ?>" <?= is_value_in_array($field_option->id, $selected_option_ids) ? 'checked' : ''; ?> <?= $custom_field->is_required == 1 ? 'required' : ''; ?>>
                                        <label class="custom-control-label" for="form_radio_<?= $field_option->id; ?>"><?= get_custom_field_option_name($field_option); ?></label>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            <?php elseif ($custom_field->field_type == "checkbox"): ?>
                <div id="checkbox_options_container_<?= $custom_field->id; ?>" class="col-sm-12 <?= $custom_field->row_width == "half" ? "col-sm-6" : "col-sm-12"; ?> col-custom-field checkbox-options-container" data-custom-field-id="<?= $custom_field->id; ?>">
                    <label><?= $custom_field_name; ?></label>
                    <div class="row">
                        <?php $field_options = $this->field_model->get_field_options($custom_field, $this->selected_lang->id);
                        $field_values = $this->field_model->get_product_custom_field_values($custom_field->id, $product->id, $this->selected_lang->id);
                        $selected_option_ids = get_array_column_values($field_values, 'selected_option_id');
                        if (!empty($field_options)):
                            foreach ($field_options as $field_option): ?>
                                <div class="col-sm-12 col-sm-3 col-custom-option">
                                    <div class="custom-control custom-checkbox custom-control-validate-input label_validate_field_<?= $custom_field->id; ?>">
                                        <input type="checkbox" class="custom-control-input <?= $custom_field->is_required == 1 ? 'required-checkbox' : ''; ?>" id="form_checkbox_<?= $field_option->id; ?>" name="field_<?= $custom_field->id; ?>[]"
                                               value="<?= $field_option->id; ?>" <?= is_value_in_array($field_option->id, $selected_option_ids) ? 'checked' : ''; ?> <?= $custom_field->is_required == 1 ? 'required' : ''; ?>>
                                        <label class="custom-control-label" for="form_checkbox_<?= $field_option->id; ?>"><?= get_custom_field_option_name($field_option); ?></label>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            <?php endif;
        endif;
    endforeach;
endif; ?>
