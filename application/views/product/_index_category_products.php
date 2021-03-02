<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if (!empty($index_categories)):
    $categories_products_array = get_index_categories_products($this, $index_categories);
    foreach ($index_categories as $category):
        $cp_length = !empty($categories_products_array[$category->id]) ? item_count($categories_products_array[$category->id]) : 0;
        if ($cp_length > 4): ?>
            <div class="col-12 section section-category-products">
                <div class="section-header">
                    <h3 class="title">
                        <a href="<?= generate_category_url($category); ?>"><?= category_name($category); ?></a>
                    </h3>
                </div>
                <div class="row-custom category-slider-container" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
                    <div class="row row-product" id="category_products_slider_<?= $category->id; ?>">
                        <?php if (!empty($categories_products_array[$category->id])):
                            foreach ($categories_products_array[$category->id] as $product): ?>
                                <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                    <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 1, 'discount_label' => 0]); ?>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                    <div id="category-products-slider-nav-<?= $category->id; ?>" class="index-products-slider-nav">
                        <button class="prev"><i class="icon-arrow-left"></i></button>
                        <button class="next"><i class="icon-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-12 section section-category-products">
                <div class="section-header">
                    <h3 class="title">
                        <a href="<?= generate_category_url($category); ?>"><?= category_name($category); ?></a>
                    </h3>
                </div>
                <div class="row row-product">
                    <?php if (!empty($categories_products_array[$category->id])):
                        foreach ($categories_products_array[$category->id] as $product): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        <?php endif;
    endforeach;
endif; ?>