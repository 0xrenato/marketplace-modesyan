<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$option_stock = $product->stock;
if (!empty($variation)):
    $variation_label = get_variation_label($variation->label_names, $this->selected_lang->id);
    if ($variation->variation_type == 'radio_button'): ?>
        <div class="col-12 col-product-variation">
            <label class="label-product-variation"><?php echo html_escape($variation_label); ?></label>
        </div>
        <div class="col-12 col-product-variation">
            <?php $variation_options = get_product_variation_options($variation->id);
            if (!empty($variation_options)):
                foreach ($variation_options as $option):
                    if ($option->is_default != 1):
                        $option_stock = $option->stock;
                    endif;
                    $option_name = get_variation_option_name($option->option_names, $this->selected_lang->id); ?>
                    <div class="custom-control custom-control-variation custom-control-validate-input">
                        <input type="radio" name="variation<?php echo $variation->id; ?>" data-name="variation<?php echo $variation->id; ?>" value="<?php echo $option->id; ?>" id="radio<?php echo $option->id; ?>" class="custom-control-input" <?php echo ($option->is_default == 1) ? 'checked' : ''; ?> onchange="select_product_variation_option('<?php echo $variation->id; ?>', 'radio_button', $(this).val());" required>
                        <?php if ($variation->option_display_type == 'image'):
                            $option_image = get_variation_main_option_image_url($option, $product_images); ?>
                            <label for="radio<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label custom-control-label-image label-variation<?php echo $variation->id; ?> <?php echo ($option_stock < 1) ? 'option-out-of-stock' : ''; ?>">
                                <img src="<?php echo $option_image; ?>" class="img-variation-option" data-toggle="tooltip" data-placement="top" title="<?php echo html_escape($option_name); ?>" alt="<?php echo html_escape($option_name); ?>">
                            </label>
                        <?php elseif ($variation->option_display_type == 'color'): ?>
                            <label for="radio<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label label-variation-color label-variation<?php echo $variation->id; ?> <?php echo ($option_stock < 1) ? 'option-out-of-stock' : ''; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo html_escape($option_name); ?>">
                                <span class="variation-color-box" style="background-color: <?php echo $option->color; ?>"></span>
                            </label>
                        <?php else: ?>
                            <label for="radio<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label label-variation<?php echo $variation->id; ?> <?php echo ($option_stock < 1) ? 'option-out-of-stock' : ''; ?>">
                                <?php echo html_escape($option_name); ?>
                            </label>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    <?php elseif ($variation->variation_type == 'dropdown'): ?>
        <div class="col-12 col-lg-6 col-product-variation item-variation">
            <div class="form-group">
                <label class="control-label"><?php echo html_escape($variation_label); ?></label>
                <select name="variation<?php echo $variation->id; ?>" id="variation_dropdown_<?php echo $variation->id; ?>" class="form-control custom-select" onchange="select_product_variation_option('<?php echo $variation->id; ?>', 'dropdown', $(this).val());" required>
                    <?php if ($variation->parent_id == 0):
                        $variation_options = get_product_variation_options($variation->id);
                        if (!empty($variation_options)):
                            foreach ($variation_options as $option):
                                if ($option->is_default != 1):
                                    $option_stock = $option->stock;
                                endif;
                                $option_name = get_variation_option_name($option->option_names, $this->selected_lang->id); ?>
                                <option value="<?php echo $option->id; ?>" <?php echo ($option_stock < 1) ? 'disabled' : ''; ?> <?php echo ($option->is_default == 1) ? 'selected' : ''; ?>><?php echo html_escape($option_name); ?></option>
                            <?php endforeach;
                        endif;
                    else: ?>
                        <option value=""><?php echo trans("select"); ?></option>
                        <?php $default_option = get_variation_default_option($variation->parent_id);
                        if (!empty($default_option)):
                            $sub_options = get_variation_sub_options($default_option->id);
                            if (!empty($sub_options)):
                                foreach ($sub_options as $sub_option):
                                    $option_name = get_variation_option_name($sub_option->option_names, $this->selected_lang->id); ?>
                                    <option value="<?php echo $sub_option->id; ?>"><?php echo html_escape($option_name); ?></option>
                                <?php endforeach;
                            endif;
                        endif;
                    endif; ?>
                </select>
            </div>
        </div>
    <?php elseif ($variation->variation_type == 'checkbox'): ?>
        <div class="col-12 col-product-variation">
            <label class="label-product-variation"><?php echo html_escape($variation_label); ?></label>
        </div>
        <div class="col-12 col-product-variation product-variation-checkbox">
            <?php $variation_options = get_product_variation_options($variation->id);
            if (!empty($variation_options)):
                foreach ($variation_options as $option):
                    if ($option->is_default != 1):
                        $option_stock = $option->stock;
                    endif;
                    $option_name = get_variation_option_name($option->option_names, $this->selected_lang->id); ?>
                    <div class="custom-control custom-control-variation custom-control-validate-input">
                        <input type="checkbox" name="variation<?php echo $variation->id; ?>[]" value="<?php echo $option->id; ?>" id="checkbox<?php echo $option->id; ?>" class="custom-control-input" required>
                        <?php if ($variation->option_display_type == 'image'):
                            $option_image = get_variation_main_option_image_url($option, $product_images); ?>
                            <label for="checkbox<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label custom-control-label-image label-variation<?php echo $variation->id; ?> <?php echo ($option_stock < 1) ? 'option-out-of-stock' : ''; ?>">
                                <img src="<?php echo $option_image; ?>" class="img-variation-option" data-toggle="tooltip" data-placement="top" title="<?php echo html_escape($option_name); ?>" alt="<?php echo html_escape($option_name); ?>">
                            </label>
                        <?php elseif ($variation->option_display_type == 'color'): ?>
                            <label for="checkbox<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label label-variation-color label-variation<?php echo $variation->id; ?> <?php echo ($option_stock < 1) ? 'option-out-of-stock' : ''; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo html_escape($option_name); ?>">
                                <span class="variation-color-box" style="background-color: <?php echo $option->color; ?>"></span>
                            </label>
                        <?php else: ?>
                            <label for="checkbox<?php echo $option->id; ?>" data-input-name="variation<?php echo $variation->id; ?>" class="custom-control-label label-variation<?php echo $variation->id; ?> <?php echo ($option_stock < 1) ? 'option-out-of-stock' : ''; ?>">
                                <?php echo html_escape($option_name); ?>
                            </label>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    <?php elseif ($variation->variation_type == 'text'): ?>
        <div class="col-12 col-lg-6 col-product-variation item-variation">
            <div class="form-group m-b-20">
                <label class="control-label"><?php echo html_escape($variation_label); ?></label>
                <input type="text" name="variation<?php echo $variation->id; ?>" class="form-control form-input" required>
            </div>
        </div>
    <?php elseif ($variation->variation_type == 'number'): ?>
        <div class="col-12 col-lg-6 col-product-variation item-variation">
            <div class="form-group m-b-20">
                <label class="control-label"><?php echo html_escape($variation_label); ?></label>
                <input type="number" name="variation<?php echo $variation->id; ?>" class="form-control form-input" min="1" required>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
