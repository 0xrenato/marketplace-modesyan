<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="promoted_posts">
    <h3 class="title"><?php echo trans("featured_products"); ?></h3>
    <p class="title-exp"><?php echo trans("featured_products_exp"); ?></p>
    <div id="row_promoted_products" class="row row-product">
        <?php foreach ($promoted_products as $product): ?>
            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" id="promoted_products_offset" value="<?php echo count($promoted_products); ?>">
    <div id="load_promoted_spinner" class="col-12 load-more-spinner">
        <div class="row">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
    <?php if ($promoted_products_count > count($promoted_products)): ?>
        <div class="row-custom text-center promoted-load-more-container">
            <a href="javascript:void(0)" class="link-see-more" onclick="load_more_promoted_products();"><span><?php echo trans("load_more"); ?>&nbsp;<i class="icon-arrow-down"></i></span></a>
        </div>
    <?php endif; ?>
</div>