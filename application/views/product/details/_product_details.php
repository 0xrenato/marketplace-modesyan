<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <?php if ($product->product_type == 'digital'):
            if ($product->is_free_product == 1):
                if ($this->auth_check):?>
                    <div class="row-custom m-t-10">
                        <?php echo form_open('download-free-digital-file-post'); ?>
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                        <?php echo form_close(); ?>
                    </div>
                <?php else: ?>
                    <div class="row-custom m-t-10">
                        <button class="btn btn-instant-download" data-toggle="modal" data-target="#loginModal"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (!empty($digital_sale)): ?>
                    <div class="row-custom m-t-10">
                        <?php echo form_open('download-purchased-digital-file-post'); ?>
                        <input type="hidden" name="sale_id" value="<?php echo $digital_sale->id; ?>">
                        <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                        <?php echo form_close(); ?>
                    </div>
                <?php else: ?>
                    <label class="label-instant-download"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                <?php endif;
            endif;
        endif; ?>

        <h1 class="product-title"><?= html_escape($title); ?></h1>
        <?php if ($product->status == 0): ?>
            <label class="badge badge-warning badge-product-status"><?php echo trans("pending"); ?></label>
        <?php elseif ($product->visibility == 0): ?>
            <label class="badge badge-danger badge-product-status"><?php echo trans("hidden"); ?></label>
        <?php endif; ?>
        <div class="row-custom meta">
            <div class="product-details-user">
                <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo character_limiter(get_shop_name_product($product), 30, '..'); ?></a>
            </div>
            <?php if ($this->general_settings->product_comments == 1): ?>
                <span><i class="icon-comment"></i><?php echo html_escape($comment_count); ?></span>
            <?php endif; ?>
            <?php if ($this->general_settings->reviews == 1): ?>
                <div class="product-details-review">
                    <?php $this->load->view('partials/_review_stars', ['review' => $product->rating]); ?>
                    <span>(<?php echo $review_count; ?>)</span>
                </div>
            <?php endif; ?>
            <span><i class="icon-heart"></i><?php echo get_product_wishlist_count($product->id); ?></span>
            <span><i class="icon-eye"></i><?php echo html_escape($product->pageviews); ?></span>
        </div>
        <div class="row-custom price">
            <div id="product_details_price_container" class="d-inline-block">
                <?php $this->load->view("product/details/_price", ['product' => $product, 'price' => $product->price, 'discount_rate' => $product->discount_rate]); ?>
                <?php if ($product->is_sold == 1): ?>
                    <strong class="lbl-sold"><?= trans("sold"); ?></strong>
                <?php endif; ?>
            </div>
            <?php $show_ask = true;
            if ($product->listing_type == 'ordinary_listing' && empty($product->external_link)):
                $show_ask = false;
            endif;
            if ($show_ask == true):?>
                <?php if ($this->auth_check): ?>
                    <button class="btn btn-contact-seller" data-toggle="modal" data-target="#messageModal"><i class="icon-envelope"></i> <?php echo trans("ask_question") ?></button>
                <?php else: ?>
                    <button class="btn btn-contact-seller" data-toggle="modal" data-target="#loginModal"><i class="icon-envelope"></i> <?php echo trans("ask_question") ?></button>
                <?php endif;
            endif; ?>
        </div>

        <div class="row-custom details">
            <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("status"); ?></label>
                    </div>
                    <div id="text_product_stock_status" class="right">
                        <?php if (check_product_stock($product)): ?>
                            <span class="status-in-stock text-success"><?php echo trans("in_stock") ?></span>
                        <?php else: ?>
                            <span class="status-in-stock text-danger"><?php echo trans("out_of_stock") ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->product_settings->marketplace_sku == 1 && !empty($product->sku)): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("sku"); ?></label>
                    </div>
                    <div class="right">
                        <span><?php echo html_escape($product->sku); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($product->product_type == 'digital' && !empty($product->files_included)): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("files_included"); ?></label>
                    </div>
                    <div class="right">
                        <span><?php echo html_escape($product->files_included); ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($product->listing_type == 'ordinary_listing'): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("uploaded"); ?></label>
                    </div>
                    <div class="right">
                        <span><?php echo time_ago($product->created_at); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo form_open(get_product_form_data($product)->add_to_cart_url, ['id' => 'form_add_cart']); ?>
<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
<div class="row">
    <div class="col-12">
        <div class="row-custom product-variations">
            <div class="row row-product-variation item-variation">
                <?php if (!empty($full_width_product_variations)):
                    foreach ($full_width_product_variations as $variation):
                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                    endforeach;
                endif;
                if (!empty($half_width_product_variations)):
                    foreach ($half_width_product_variations as $variation):
                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12"><?php $this->load->view('product/details/_messages'); ?></div>
</div>
<div class="row">
    <div class="col-12 product-add-to-cart-container">
        <?php if ($product->is_sold != 1 && $product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
            <div class="number-spinner">
                <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                        </span>
                    <input type="text" class="form-control text-center" name="product_quantity" value="1">
                    <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                        </span>
                </div>
            </div>
        <?php endif; ?>
        <?php $buttton = get_product_form_data($product)->button;
        if ($product->is_sold != 1 && !empty($buttton)):?>
            <div class="button-container">
                <?php echo $buttton; ?>
            </div>
        <?php endif; ?>
        <div class="button-container button-container-wishlist">
            <?php if ($this->product_model->is_product_in_wishlist($product->id) == 1): ?>
                <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart"></i><span><?php echo trans("remove_from_wishlist"); ?></span></a>
            <?php else: ?>
                <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart-o"></i><span><?php echo trans("add_to_wishlist"); ?></span></a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($product->demo_url)): ?>
        <div class="col-12 product-add-to-cart-container">
            <div class="button-container">
                <a href="<?php echo $product->demo_url; ?>" target="_blank" class="btn btn-md btn-live-preview"><i class="icon-preview"></i><?php echo trans("live_preview") ?></a>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php echo form_close(); ?>

<!--Include social share-->
<?php $this->load->view("product/details/_product_share"); ?>