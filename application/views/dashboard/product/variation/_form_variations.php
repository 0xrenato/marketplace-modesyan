<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="addVariationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <form id="form_add_product_variation" novalidate>
                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("add_variation"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 tab-variation">
                            <div class="form-group m-b-10">
                                <label class="control-label"><?php echo trans('label'); ?></label>
                                <?php foreach ($this->languages as $language): ?>
                                    <?php if ($language->id == $this->selected_lang->id): ?>
                                        <input type="text" id="input_variation_label" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255" required>
                                    <?php else: ?>
                                        <input type="text" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('variation_type'); ?></label>
                                <select name="variation_type" class="form-control custom-select" onchange="show_hide_form_option_images(this.value);" required>
                                    <option value="radio_button"><?php echo trans('radio_button'); ?></option>
                                    <option value="dropdown"><?php echo trans('dropdown'); ?></option>
                                    <option value="checkbox"><?php echo trans('checkbox'); ?></option>
                                    <option value="text" checked><?php echo trans('text'); ?></option>
                                    <option value="number"><?php echo trans('number'); ?></option>
                                </select>
                            </div>
                            <div class="form-group display-none form-group-parent-variation">
                                <label class="control-label"><?php echo trans('parent_variation'); ?></label>
                                <select name="parent_id" class="form-control custom-select">
                                    <option value=""><?php echo trans("none"); ?></option>
                                    <?php if (!empty($product_variations)):
                                        foreach ($product_variations as $variation):
                                            if ($variation->variation_type == "dropdown"): ?>
                                                <option value="<?php echo $variation->id; ?>"><?php echo $variation->id . " - " . html_escape(get_variation_label($variation->label_names, $this->selected_lang->id)) . ' - ' . trans($variation->variation_type); ?></option>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="form-group m-0 form-group-display-type">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans('option_display_type'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="option_display_type" value="text" id="option_display_type_1" class="custom-control-input" checked>
                                            <label for="option_display_type_1" class="custom-control-label"><?php echo trans('text'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="option_display_type" value="image" id="option_display_type_2" class="custom-control-input">
                                            <label for="option_display_type_2" class="custom-control-label"><?php echo trans('image'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="option_display_type" value="color" id="option_display_type_3" class="custom-control-input">
                                            <label for="option_display_type_3" class="custom-control-label"><?php echo trans('color'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-show-option-images">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans('show_option_images_on_slider'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="show_images_on_slider" value="1" id="show_images_on_slider_when_selected_1" class="custom-control-input">
                                            <label for="show_images_on_slider_when_selected_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="show_images_on_slider" value="0" id="show_images_on_slider_when_selected_2" class="custom-control-input" checked>
                                            <label for="show_images_on_slider_when_selected_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (empty(is_there_variation_uses_different_price($product->id)) && $product->listing_type != 'bidding'): ?>
                                <div class="form-group form-group-show-option-images">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="control-label"><?php echo trans('use_different_price_for_options'); ?></label>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-custom-option">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="use_different_price" value="1" id="use_different_price_1" class="custom-control-input">
                                                <label for="use_different_price_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-custom-option">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="use_different_price" value="0" id="use_different_price_2" class="custom-control-input" checked>
                                                <label for="use_different_price_2" class="custom-control-label"><?php echo trans('no'); ?></label>
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
                                            <input type="radio" name="is_visible" value="1" id="edit_visible_1" class="custom-control-input" checked>
                                            <label for="edit_visible_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="is_visible" value="0" id="edit_visible_2" class="custom-control-input">
                                            <label for="edit_visible_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success btn-variation float-right"><?php echo trans("add_variation"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editVariationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <form id="form_edit_product_variation" novalidate>
                <div id="response_product_variation_edit"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addVariationOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <div id="response_product_add_variation_option"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewVariationOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation modal-variation-options" role="document">
        <div class="modal-content">
            <div id="response_product_variation_options_edit"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="editVariationOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <div id="response_product_edit_variation_option"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="variationModalSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <form id="form_select_product_variation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("created_variations"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (empty($user_variations)): ?>
                        <p class="text-center m-t-20"><?php echo trans("msg_no_created_variations"); ?></p>
                    <?php else: ?>
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('select_variation'); ?></label>
                            <select name="variation_id" class="form-control custom-select" required>
                                <?php foreach ($user_variations as $user_variation):
                                    if ($user_variation->insert_type == "new"): ?>
                                        <option value="<?php echo $user_variation->id; ?>"><?php echo $user_variation->id . " - " . html_escape(get_variation_label($user_variation->label_names, $this->selected_lang->id)) . ' - ' . trans($user_variation->variation_type); ?></option>
                                    <?php endif;
                                endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <?php if (!empty($user_variations)): ?>
                        <button type="submit" class="btn btn-md btn-success btn-variation"><?php echo trans("select"); ?></button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view("dashboard/product/variation/_js_variations"); ?>
