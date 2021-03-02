<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col-sm-12 col-lg-4 order-summary-container">
    <h2 class="cart-section-title"><?php echo trans("order_summary"); ?> (1)</h2>
    <div class="right">
        <?php if (!empty($promoted_plan)):
            $product = get_active_product($promoted_plan->product_id);
            if (!empty($product)):?>
                <div class="cart-order-details">
                    <div class="item">
                        <div class="item-left">
                            <div class="img-cart-product">
                                <a href="<?php echo generate_product_url($product); ?>">
                                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($product->id, 'image_small'); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                </a>
                            </div>
                        </div>
                        <div class="item-right">
                            <div class="list-item">
                                <a href="<?php echo generate_product_url($product); ?>">
                                    <?php echo get_product_title($product); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-right">
                            <div class="list-item m-t-15">
                                <label><?php echo trans("promote_plan"); ?>:</label>
                                <strong class="lbl-price"><?php echo $promoted_plan->purchased_plan; ?></strong>
                            </div>
                            <div class="list-item">
                                <label><?php echo trans("price"); ?>:</label>
                                <strong class="lbl-price"><?= price_decimal($promoted_plan->total_amount, $this->selected_currency->code, true); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-custom m-t-30">
                    <strong><?php echo trans("subtotal"); ?><span class="float-right"><?= price_decimal($promoted_plan->total_amount, $this->selected_currency->code, true); ?></span></strong>
                </div>
                <div class="row-custom">
                    <p class="line-seperator"></p>
                </div>
                <div class="row-custom">
                    <strong><?php echo trans("total"); ?><span class="float-right"><?= price_decimal($promoted_plan->total_amount, $this->selected_currency->code, true); ?></span></strong>
                </div>
            <?php endif;
        endif; ?>
    </div>
</div>




