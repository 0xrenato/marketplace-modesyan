<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($product->is_sold == 1): ?>
    <strong class="lbl-price lbl-price-sold">
        <?= price_formatted($price, $product->currency); ?>
        <span class="price-line"></span>
    </strong>
<?php else:
    if ($product->is_free_product == 1):?>
        <strong class="lbl-free"><?= trans("free"); ?></strong>
    <?php else:
        if (!empty($price)):
            if ($product->listing_type == 'sell_on_site' || $product->listing_type == 'license_key'):
                if (!empty($discount_rate)): ?>
                    <strong class="lbl-price">
                        <b class="discount-original-price">
                            <?= price_formatted($price, $product->currency, true); ?>
                            <span class="price-line"></span>
                        </b>
                        <?= price_formatted(calculate_product_price($price, $discount_rate), $product->currency, true); ?>
                    </strong>
                    <div class="discount-rate">
                        -<?= discount_rate_format($discount_rate); ?>
                    </div>
                <?php else: ?>
                    <strong class="lbl-price">
                        <?= price_formatted($price, $product->currency, true); ?>
                    </strong>
                <?php endif;
            elseif ($product->listing_type == 'ordinary_listing'):
                if ($this->product_settings->classified_price == 1):?>
                    <strong class="lbl-price">
                        <?= price_formatted($price, $product->currency); ?>
                    </strong>
                <?php endif;
            endif;
        endif;
    endif;
endif; ?>


