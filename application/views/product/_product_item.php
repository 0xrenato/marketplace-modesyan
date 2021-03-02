<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="product-item">
<div class="row-custom<?php echo (!empty($product->image_second)) ? ' product-multiple-image' : ''; ?>">
<a class="item-wishlist-button item-wishlist-enable <?php echo (is_product_in_wishlist($product) == 1) ? 'item-wishlist' : ''; ?>" data-product-id="<?php echo $product->id; ?>"></a>
<div class="img-product-container">
<?php if (!empty($is_slider)): ?>
<a href="<?php echo generate_product_url($product); ?>">
<img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-lazy="<?php echo get_product_item_image($product); ?>" alt="<?php echo get_product_title($product); ?>" class="img-fluid img-product">
<?php if (!empty($product->image_second)): ?>
<img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-lazy="<?php echo get_product_item_image($product, true); ?>" alt="<?php echo get_product_title($product); ?>" class="img-fluid img-product img-second">
<?php endif; ?>
</a>
<?php else: ?>
<a href="<?php echo generate_product_url($product); ?>">
<img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product">
<?php if (!empty($product->image_second)): ?>
<img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product, true); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product img-second">
<?php endif; ?>
</a>
<?php endif; ?>
<div class="product-item-options">
<a href="javascript:void(0)" class="item-option btn-add-remove-wishlist" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
<?php if (is_product_in_wishlist($product) == 1): ?>
<i class="icon-heart"></i>
<?php else: ?>
<i class="icon-heart-o"></i>
<?php endif; ?>
</a>
<?php if (($product->listing_type == "sell_on_site" || $product->listing_type == "bidding") && $product->is_free_product != 1):
if (!empty($product->has_variation) || $product->listing_type == "bidding"):?>
<a href="<?= generate_product_url($product); ?>" class="item-option" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("view_options"); ?>">
<i class="icon-cart"></i>
</a>
<?php else: ?>
<a href="javascript:void(0)" class="item-option btn-item-add-to-cart" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
<i class="icon-cart"></i>
</a>
<?php endif;
endif; ?>
</div>
<?php if (!empty($product->discount_rate) && !empty($discount_label)): ?>
<span class="badge badge-discount">-<?= $product->discount_rate; ?>%</span>
<?php endif; ?>
</div>
<?php if ($product->is_promoted && $this->general_settings->promoted_products == 1 && isset($promoted_badge) && $promoted_badge == true): ?>
<span class="badge badge-dark badge-promoted"><?php echo trans("featured"); ?></span>
<?php endif; ?>
</div>
<div class="row-custom item-details">
<h3 class="product-title">
<a href="<?php echo generate_product_url($product); ?>"><?= get_product_title($product); ?></a>
</h3>
<p class="product-user text-truncate">
<a href="<?php echo generate_profile_url($product->user_slug); ?>">
<?php echo get_shop_name_product($product); ?>
</a>
</p>
<div class="product-item-rating">
<?php if ($this->general_settings->reviews == 1) {
$this->load->view('partials/_review_stars', ['review' => $product->rating]);
} ?>
<span class="item-wishlist"><i class="icon-heart-o"></i><?php echo $product->wishlist_count; ?></span>
</div>
<div class="item-meta">
<?php $this->load->view('product/_price_product_item', ['product' => $product]); ?>
</div>
</div>
</div>