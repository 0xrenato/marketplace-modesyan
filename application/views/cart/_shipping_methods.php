<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $has_methods = false;
$show_button = true;
if (!empty($shipping_methods)) {
    foreach ($shipping_methods as $shipping_method) {
        if (!empty($shipping_method->methods) && item_count($shipping_method->methods) > 0) {
            $has_methods = true;
        } else {
            $show_button = false;
        }
    }
}

if ($has_methods == false):?>
    <p class="text-muted"><?= trans("no_delivery_is_made_to_address"); ?></p>
<?php else: ?>
    <div class="row">
        <div class="col-12 m-t-30">
            <p class="text-shipping-address"><?= trans("shipping_method"); ?></p>
        </div>
        <?php if (item_count($shipping_methods) > 1 && !empty($shipping_methods[0]->methods)): ?>
            <div class="col-12">
                <p class="text-muted"><?= trans("products_sent_different_stores"); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php if (empty($selected_shipping_method_ids)):
        $selected_shipping_method_ids = array();
    endif;
    if (!empty($shipping_methods)):
        foreach ($shipping_methods as $shipping_method): ?>
            <div class="row">
                <div class="col-12 cart-seller-shipping-options">
                    <p class="p-cart-shop">
                        <svg width="16" height="16" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                        </svg>&nbsp;&nbsp;
                        <strong><?= $shipping_method->shop_name; ?></strong>
                    </p>
                    <?php if (empty($shipping_method->methods)): ?>
                        <p class="text-muted"><?= trans("seller_does_not_ship_to_address"); ?></p>
                    <?php else:
                        foreach ($shipping_method->methods as $method):
                            $is_selected = 0;
                            if (in_array($method->id, $selected_shipping_method_ids)) {
                                $is_selected = 1;
                            } else {
                                $is_selected = $method->is_selected;
                            }
                            if ($method->method_type == "free_shipping"):
                                if ($method->is_free_shipping == 1):?>
                                    <div class="row-custom m-t-5">
                                        <div class="custom-control custom-radio cart-shipping-method">
                                            <input type="radio" class="custom-control-input" id="shipping_method_<?= $method->id; ?>" name="shipping_method_<?= $shipping_method->shop_id; ?>" value="<?= $method->id; ?>" <?= $is_selected == 1 ? 'checked' : ''; ?> required>
                                            <label class="custom-control-label" for="shipping_method_<?= $method->id; ?>">
                                                <strong class="method-name"><?= $method->name; ?></strong>
                                            </label>
                                        </div>
                                    </div>
                                <?php endif;
                            else: ?>
                                <div class="row-custom m-t-5">
                                    <div class="custom-control custom-radio cart-shipping-method">
                                        <input type="radio" class="custom-control-input" id="shipping_method_<?= $method->id; ?>" name="shipping_method_<?= $shipping_method->shop_id; ?>" value="<?= $method->id; ?>" <?= $is_selected == 1 ? 'checked' : ''; ?> required>
                                        <label class="custom-control-label" for="shipping_method_<?= $method->id; ?>">
                                            <strong class="method-name"><?= $method->name; ?></strong>
                                            <strong><?= price_decimal($method->cost, $this->selected_currency->code, true); ?></strong>
                                        </label>
                                    </div>
                                </div>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </div>
            </div>
        <?php endforeach;
    endif; ?>

    <?php if ($show_button == true): ?>
        <div class="form-group m-t-60">
            <a href="<?php echo generate_url("cart"); ?>" class="link-underlined link-return-cart"><&nbsp;<?php echo trans("return_to_cart"); ?></a>
            <button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-cart-shipping float-right"><?php echo trans("continue_to_payment_method") ?></button>
        </div>
    <?php endif;
endif; ?>
