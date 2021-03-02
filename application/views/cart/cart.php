<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ($cart_items != null): ?>
                    <div class="shopping-cart">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <div class="left">
                                    <h1 class="cart-section-title"><?php echo trans("my_cart"); ?> (<?php echo get_cart_product_count(); ?>)</h1>
                                    <?php if (!empty($cart_items)):
                                        foreach ($cart_items as $cart_item):
                                            $product = get_active_product($cart_item->product_id);
                                            if (!empty($product)): ?>
                                                <div class="item">
                                                    <div class="cart-item-image">
                                                        <div class="img-cart-product">
                                                            <a href="<?php echo generate_product_url($product); ?>">
                                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="cart-item-details">
                                                        <?php if ($product->product_type == 'digital'): ?>
                                                            <div class="list-item">
                                                                <label class="label-instant-download label-instant-download-sm"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="list-item">
                                                            <a href="<?php echo generate_product_url($product); ?>">
                                                                <?php echo html_escape($cart_item->product_title); ?>
                                                            </a>
                                                            <?php if (empty($cart_item->is_stock_available)): ?>
                                                                <div class="lbl-enough-quantity"><?php echo trans("out_of_stock"); ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="list-item seller">
                                                            <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo get_shop_name_product($product); ?></a>
                                                        </div>
                                                        <?php if ($cart_item->purchase_type != 'bidding'): ?>
                                                            <div class="list-item m-t-15">
                                                                <label><?php echo trans("unit_price"); ?>:</label>
                                                                <strong class="lbl-price">
                                                                    <?= price_decimal($cart_item->unit_price, $cart_item->currency);
                                                                    if (!empty($cart_item->discount_rate)): ?>
                                                                        <span class="discount-rate-cart">
                                                                        (<?php echo discount_rate_format($cart_item->discount_rate); ?>)
                                                                    </span>
                                                                    <?php endif; ?>
                                                                </strong>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="list-item">
                                                            <label><?php echo trans("total"); ?>:</label>
                                                            <strong class="lbl-price"><?= price_decimal($cart_item->total_price, $cart_item->currency); ?></strong>
                                                        </div>
                                                        <?php if (!empty($product->vat_rate)): ?>
                                                            <div class="list-item">
                                                                <label><?php echo trans("vat"); ?>&nbsp;(<?php echo $product->vat_rate; ?>%):</label>
                                                                <strong class="lbl-price"><?= price_decimal($cart_item->product_vat, $cart_item->currency); ?></strong>
                                                            </div>
                                                        <?php endif; ?>
                                                        <a href="javascript:void(0)" class="btn btn-md btn-outline-gray btn-cart-remove" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><i class="icon-close"></i> <?php echo trans("remove"); ?></a>
                                                    </div>
                                                    <div class="cart-item-quantity">
                                                        <?php if ($cart_item->purchase_type == 'bidding'): ?>
                                                            <span><?php echo trans("quantity") . ": " . $cart_item->quantity; ?></span>
                                                        <?php else: ?>
                                                            <div class="number-spinner">
                                                                <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default btn-spinner-minus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="dwn">-</button>
                                                                        </span>
                                                                    <input type="text" id="q-<?php echo $cart_item->cart_item_id; ?>" class="form-control text-center" value="<?php echo $cart_item->quantity; ?>" data-product-id="<?php echo $cart_item->product_id; ?>" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>">
                                                                    <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default btn-spinner-plus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up">+</button>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </div>
                                <a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom m-t-15"><i class="icon-arrow-left m-r-2"></i><?php echo trans("keep_shopping") ?></a>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="right">
                                    <div class="row-custom m-b-15">
                                        <strong><?php echo trans("subtotal"); ?><span class="float-right"><?= price_decimal($cart_total->subtotal, $cart_total->currency); ?></span></strong>
                                    </div>
                                    <?php if (!empty($cart_total->vat)): ?>
                                        <div class="row-custom">
                                            <strong><?php echo trans("vat"); ?><span class="float-right"><?= price_decimal($cart_total->vat, $cart_total->currency); ?></span></strong>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row-custom">
                                        <p class="line-seperator"></p>
                                    </div>
                                    <div class="row-custom m-b-10">
                                        <strong><?php echo trans("total"); ?><span class="float-right"><?= price_decimal($cart_total->total_before_shipping, $cart_total->currency); ?></span></strong>
                                    </div>
                                    <div class="row-custom m-t-30 m-b-15">
                                        <?php if (empty($cart_total->is_stock_available)): ?>
                                            <a href="javascript:void(0)" class="btn btn-block"><?php echo trans("continue_to_checkout"); ?></a>
                                        <?php else:
                                            if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1): ?>
                                                <a href="#" class="btn btn-block" data-toggle="modal" data-target="#loginModal"><?php echo trans("continue_to_checkout"); ?></a>
                                            <?php else:
                                                if ($cart_has_physical_product == true && $this->product_settings->marketplace_shipping == 1): ?>
                                                    <a href="<?php echo generate_url("cart", "shipping"); ?>" class="btn btn-block"><?php echo trans("continue_to_checkout"); ?></a>
                                                <?php else: ?>
                                                    <a href="<?php echo generate_url("cart", "payment_method"); ?>" class="btn btn-block"><?php echo trans("continue_to_checkout"); ?></a>
                                                <?php endif;
                                            endif;
                                        endif; ?>
                                    </div>
                                    <div class="payment-icons">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/maestro.svg" alt="maestro">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/discover.svg" alt="discover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="shopping-cart-empty">
                        <p><strong class="font-600"><?php echo trans("your_cart_is_empty"); ?></strong></p>
                        <a href="<?php echo lang_base_url(); ?>" class="btn btn-lg btn-custom"><i class="icon-arrow-left"></i>&nbsp;<?php echo trans("shop_now"); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->