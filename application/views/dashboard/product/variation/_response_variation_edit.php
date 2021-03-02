<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<input type="hidden" name="variation_id" value="<?php echo $variation->id; ?>">
<input type="hidden" name="product_id" value="<?php echo $variation->product_id; ?>">
<div class="modal-header">
    <h5 class="modal-title"><?php echo trans("edit_variation"); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="icon-close"></i></span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 tab-variation">
            <div class="form-group">
                <label class="control-label"><?php echo trans('label'); ?></label>
                <?php foreach ($this->languages as $language): ?>
                    <?php if ($language->id == $this->selected_lang->id): ?>
                        <input type="text" id="input_variation_label_edit" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" value="<?php echo get_variation_label($variation->label_names, $language->id); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255" required>
                    <?php else: ?>
                        <input type="text" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" value="<?php echo get_variation_label($variation->label_names, $language->id); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label class="control-label"><?php echo trans('variation_type'); ?></label>
                <select name="variation_type" class="form-control custom-select" onchange="show_hide_form_option_images(this.value);" required>
                    <option value="radio_button" <?php echo ($variation->variation_type == 'radio_button') ? 'selected' : ''; ?>><?php echo trans('radio_button'); ?></option>
                    <option value="dropdown" <?php echo ($variation->variation_type == 'dropdown') ? 'selected' : ''; ?>><?php echo trans('dropdown'); ?></option>
                    <option value="checkbox" <?php echo ($variation->variation_type == 'checkbox') ? 'selected' : ''; ?>><?php echo trans('checkbox'); ?></option>
                    <option value="text" <?php echo ($variation->variation_type == 'text') ? 'selected' : ''; ?>><?php echo trans('text'); ?></option>
                    <option value="number" <?php echo ($variation->variation_type == 'number') ? 'selected' : ''; ?>><?php echo trans('number'); ?></option>
                </select>
            </div>
            <div class="form-group m-0 form-group-display-type <?php echo ($variation->variation_type != 'radio_button' && $variation->variation_type != 'checkbox') ? 'display-none' : ''; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('option_display_type'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="option_display_type" value="text" id="option_display_type_edit_1" class="custom-control-input" <?php echo ($variation->option_display_type == 'text') ? 'checked' : ''; ?>>
                            <label for="option_display_type_edit_1" class="custom-control-label"><?php echo trans('text'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="option_display_type" value="image" id="option_display_type_edit_2" class="custom-control-input" <?php echo ($variation->option_display_type == 'image') ? 'checked' : ''; ?>>
                            <label for="option_display_type_edit_2" class="custom-control-label"><?php echo trans('image'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="option_display_type" value="color" id="option_display_type_edit_3" class="custom-control-input" <?php echo ($variation->option_display_type == 'color') ? 'checked' : ''; ?>>
                            <label for="option_display_type_edit_3" class="custom-control-label"><?php echo trans('color'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group <?php echo ($variation->variation_type != "dropdown") ? "display-none" : ""; ?>">
                <label class="control-label"><?php echo trans('parent_variation'); ?></label>
                <select name="parent_id" class="form-control custom-select">
                    <option value=""><?php echo trans("none"); ?></option>
                    <?php if (!empty($product_variations)):
                        foreach ($product_variations as $item):
                            if ($item->variation_type == "dropdown"): ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($variation->parent_id == $item->id) ? 'selected' : ''; ?>><?php echo $item->id . " - " . html_escape(get_variation_label($item->label_names, $this->selected_lang->id)) . ' - ' . trans($item->variation_type); ?></option>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="form-group m-0 form-group-show-option-images <?php echo ($variation->variation_type != 'radio_button' && $variation->variation_type != 'dropdown') ? 'display-none' : ''; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('show_option_images_on_slider'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="show_images_on_slider" value="1" id="show_images_on_slider_when_selected_edit_1" class="custom-control-input" <?php echo ($variation->show_images_on_slider == 1) ? 'checked' : ''; ?>>
                            <label for="show_images_on_slider_when_selected_edit_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="show_images_on_slider" value="0" id="show_images_on_slider_when_selected_edit_2" class="custom-control-input" <?php echo ($variation->show_images_on_slider != 1) ? 'checked' : ''; ?>>
                            <label for="show_images_on_slider_when_selected_edit_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (empty(is_there_variation_uses_different_price($variation->product_id, $variation->id)) && $product->listing_type != 'bidding'): ?>
                <div class="form-group form-group-show-option-images">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label"><?php echo trans('use_different_price_for_options'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="use_different_price" value="1" id="use_different_price_edit_1" class="custom-control-input" <?php echo ($variation->use_different_price == 1) ? 'checked' : ''; ?>>
                                <label for="use_different_price_edit_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="use_different_price" value="0" id="use_different_price_edit_2" class="custom-control-input" <?php echo ($variation->use_different_price != 1) ? 'checked' : ''; ?>>
                                <label for="use_different_price_edit_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group m-0">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('visible'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="is_visible" value="1" id="edit_visible_edit_1" class="custom-control-input" <?php echo ($variation->is_visible == 1) ? 'checked' : ''; ?>>
                            <label for="edit_visible_edit_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="is_visible" value="0" id="edit_visible_edit_2" class="custom-control-input" <?php echo ($variation->is_visible != 1) ? 'checked' : ''; ?>>
                            <label for="edit_visible_edit_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row-custom">
        <button type="button" class="btn btn-md btn-danger color-white float-left hidden btn-show-variation-form"><i class="icon-arrow-left"></i><?php echo trans("back") ?></button>
        <button type="submit" class="btn btn-md btn-secondary btn-variation float-right"><?php echo trans("save_changes"); ?></button>
    </div>
</div>

