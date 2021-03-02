<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="form_edit_product_variation_option" novalidate>
    <input type="hidden" name="variation_id" id="form_edit_variation_id" value="<?php echo $variation->id; ?>">
    <input type="hidden" name="option_id" value="<?php echo $variation_option->id; ?>">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo trans("edit_option"); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="icon-close"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 box-variation-options">
                <div class="form-group m-b-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label"><?php echo trans('default_option'); ?>&nbsp;<small class="text-muted">(<?php echo trans('default_option_exp'); ?>)</small></label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="is_default" value="1" id="is_default_1_edit" class="custom-control-input" <?php echo ($variation_option->is_default == 1) ? "checked" : ""; ?>>
                                <label for="is_default_1_edit" class="custom-control-label"><?php echo trans("yes"); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="is_default" value="0" id="is_default_2_edit" class="custom-control-input" <?php echo ($variation_option->is_default != 1) ? "checked" : ""; ?>>
                                <label for="is_default_2_edit" class="custom-control-label"><?php echo trans("no"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-b-5">
                    <label class="control-label"><?php echo trans("option_name"); ?></label>
                    <?php if (!empty($this->languages)): ?>
                        <?php if (count($this->languages) <= 1): ?>
                            <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)); ?>" maxlength="255">
                        <?php else: ?>
                            <?php foreach ($this->languages as $language): ?>
                                <?php if ($language->id == $this->selected_lang->id): ?>
                                    <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                <?php else: ?>
                                    <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if (!empty($variation->parent_id != 0)): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('parent_option'); ?></label>
                        <select name="parent_id" class="form-control custom-select">
                            <?php if (!empty($parent_variation_options)):
                                foreach ($parent_variation_options as $parent_option): ?>
                                    <option value="<?php echo $parent_option->id; ?>" <?php echo ($parent_option->id == $variation_option->parent_id) ? "selected" : ""; ?>><?php echo html_escape(get_variation_option_name($parent_option->option_names, $this->selected_lang->id)); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                            <label class="control-label"><?php echo trans('stock'); ?></label>
                            <input type="number" name="option_stock" class="form-control form-input" value="<?php echo $variation_option->stock; ?>" min="0">
                        </div>
                        <?php if ($variation->variation_type != "dropdown" && $variation->option_display_type == "color"): ?>
                            <div class="col-sm-6">
                                <label class="control-label"><?php echo trans('color'); ?>&nbsp;<small class="text-muted">(<?php echo trans("optional"); ?>)</small></label>
                                <div class="input-group colorpicker">
                                    <input type="text" class="form-control" name="option_color" maxlength="200" value="<?php echo html_escape($variation_option->color); ?>" placeholder="<?php echo trans('color'); ?>">
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($variation->use_different_price == 1): ?>
                    <div class="form-group hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans("price"); ?></label>
                                        <div id="price_input_container_variation" class="<?php echo ($variation_option->use_default_price == 1) ? 'display-none' : ''; ?>">
                                            <div class="input-group">
                                                <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                                <input type="text" name="option_price" id="product_price_input_variation" value="<?php echo get_price($variation_option->price, "input"); ?>" class="form-control form-input price-input validate-price-input m-0" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="use_default_price" id="checkbox_price_variation" value="1" <?php echo ($variation_option->use_default_price == 1) ? 'checked' : ''; ?>>
                                            <label for="checkbox_price_variation" class="custom-control-label"><?php echo trans("use_default_price"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans("discount_rate"); ?></label>
                                        <div id="discount_input_container_variation" class="<?php echo ($variation_option->no_discount == 1) ? 'display-none' : ''; ?>">
                                            <div class="input-group">
                                                <span class="input-group-addon">%</span>
                                                <input type="number" name="option_discount_rate" id="input_discount_rate_variation" class="form-control form-input m-0" value="<?php echo $variation_option->discount_rate; ?>" min="0" max="99" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="no_discount" id="checkbox_discount_rate_variation" value="1" <?php echo ($variation_option->no_discount == 1) ? 'checked' : ''; ?>>
                                            <label for="checkbox_discount_rate_variation" class="custom-control-label"><?php echo trans("no_discount"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($variation->option_display_type == "image" || $variation->show_images_on_slider == 1): ?>
                    <div class="form-group hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo trans("images"); ?>&nbsp;<small class="text-muted">(<?php echo trans("optional"); ?>)</small></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="dm-uploader-container">
                                            <div id="drag-and-drop-zone-variation-image" class="dm-uploader text-center">
                                                <p class="dm-upload-icon">
                                                    <i class="icon-upload"></i>
                                                </p>
                                                <p class="dm-upload-text"><?php echo trans("drag_drop_images_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>

                                                <a class='btn btn-md dm-btn-select-files'>
                                                    <input type="file" name="file" size="40" multiple="multiple">
                                                </a>
                                                <ul class="dm-uploaded-files" id="files-variation-image">
                                                    <?php if (!empty($variation_option_images)):
                                                        foreach ($variation_option_images as $image): ?>
                                                            <li class="media" id="uploaderFile<?php echo $image->id; ?>">
                                                                <img src="<?php echo get_variation_option_image_url($image); ?>" alt="">
                                                                <a href="javascript:void(0)" class="btn-img-delete btn-delete-variation-image" data-variation-id="<?php echo $variation->id; ?>" data-file-id="<?php echo $image->id; ?>">
                                                                    <i class="icon-close"></i>
                                                                </a>
                                                                <?php if ($image->is_main == 1): ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-success btn-is-image-main btn-set-variation-image-main"><?php echo trans("main"); ?></a>
                                                                <?php else: ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-variation-image-main" data-file-id="<?php echo $image->id; ?>" data-option-id="<?php echo $image->variation_option_id; ?>"><?php echo trans("main"); ?></a>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach;
                                                    endif; ?>
                                                </ul>
                                                <input type="hidden" id="variation_option_id" value="<?php echo $variation_option->id ?>">
                                            </div>
                                        </div>

                                        <!-- File item template -->
                                        <script type="text/html" id="files-template-variation-image">
                                            <li class="media">
                                                <img class="preview-img" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="bg">
                                                <div class="media-body">
                                                    <div class="progress">
                                                        <div class="dm-progress-waiting"><?php echo trans("waiting"); ?></div>
                                                        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </li>
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row-custom">
            <button type="button" id="btn_edit_variation_option" class="btn btn-md btn-info color-white float-right"><?php echo trans("save_changes"); ?></button>
        </div>
    </div>
</form>
