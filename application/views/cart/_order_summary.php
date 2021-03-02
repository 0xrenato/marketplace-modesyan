<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?php echo trans("order_summary"); ?> (<?php echo get_cart_product_count(); ?>)</h2>
    <div class="right">
        <?php $is_physical = false; ?>
        <div class="cart-order-details">
            <?php if (!empty($cart_items)):
                foreach ($cart_items as $cart_item):
                    $product = get_active_product($cart_item->product_id);
                    if (!empty($product)):
                        if ($product->product_type == 'physical') {
                            $is_physical = true;
                        } ?>
                        <div class="item">
                            <div class="item-left">
                                <div class="img-cart-product">
                                    <a href="<?php echo generate_product_url($product); ?>">
                                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                    </a>
                                </div>
                            </div>
                            <div class="item-right">
                                <?php if ($product->product_type == 'digital'): ?>
                                    <div class="list-item">
                                        <label class="label-instant-download label-instant-download-sm"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                                    </div>
                                <?php endif; ?>
                                <div class="list-item">
                                    <a href="<?php echo generate_product_url($product); ?>">
                                        <?php echo html_escape($cart_item->product_title); ?>
                                    </a>
                                </div>
                                <div class="list-item seller">
                                    <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo get_shop_name_product($product); ?></a>
                                </div>
                                <div class="list-item m-t-15">
                                    <label><?php echo trans("quantity"); ?>:</label>
                                    <strong class="lbl-price"><?php echo $cart_item->quantity; ?></strong>
                                </div>
                                <div class="list-item">
                                    <label><?php echo trans("price"); ?>:</label>
                                    <strong class="lbl-price"><?= price_decimal($cart_item->total_price, $cart_item->currency); ?></strong>
                                </div>
                                <?php if (!empty($cart_item->product_vat)): ?>
                                    <div class="list-item">
                                        <label><?php echo trans("vat"); ?>:</label>
                                        <strong><?= price_decimal($cart_item->product_vat, $cart_item->currency); ?></strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif;
                endforeach;
            endif; ?>
        </div>
        <div class="row-custom m-t-30 m-b-10">
            <strong><?php echo trans("subtotal"); ?><span class="float-right"><?= price_decimal($cart_total->subtotal, $cart_total->currency); ?></span></strong>
        </div>
        <?php if (!empty($cart_total->vat)): ?>
            <div class="row-custom m-b-10">
                <strong><?php echo trans("vat"); ?><span class="float-right"><?= price_decimal($cart_total->vat, $cart_total->currency); ?></span></strong>
            </div>
        <?php endif; ?>

        <?php if (!empty($show_shipping_cost) && !empty($cart_total->shipping_cost)): ?>
            <div class="row-custom">
                <strong><?php echo trans("shipping"); ?><span class="float-right"><?= price_decimal($cart_total->shipping_cost, $cart_total->currency); ?></span></strong>
            </div>
        <?php endif; ?>
        <div class="row-custom">
            <p class="line-seperator"></p>
        </div>
        <?php if (!empty($show_shipping_cost) && !empty($cart_total->shipping_cost)): ?>
            <div class="row-custom">
                <strong><?php echo trans("total"); ?><span class="float-right"><?= price_decimal($cart_total->total, $cart_total->currency); ?></span></strong>
            </div>
        <?php else: ?>
            <div class="row-custom">
                <strong><?php echo trans("total"); ?><span class="float-right"><?= price_decimal($cart_total->total_before_shipping, $cart_total->currency); ?></span></strong>
            </div>
        <?php endif; ?>
    </div>
</div>