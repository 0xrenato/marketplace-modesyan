<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="section-slider">
    <?php if (!empty($slider_items) && $this->general_settings->slider_status == 1):
        $this->load->view("partials/_main_slider");
    endif; ?>
</div>
<!-- Wrapper -->
<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="row">
            <h1 class="index-title"><?php echo html_escape($this->settings->site_title); ?></h1>
            <?php if (item_count($featured_categories) > 0 && $this->general_settings->featured_categories == 1): ?>
                <div class="col-12 section section-categories">
                    <!-- featured categories -->
                    <?php $this->load->view("partials/_featured_categories"); ?>
                </div>
            <?php endif; ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'featured_categories']); ?>

            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_1", "class" => ""]); ?>
                </div>
            </div>

            <?php $this->load->view('product/_special_offers', ['index_categories' => $index_categories]); ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'special_offers']); ?>

            <?php if ($this->general_settings->index_promoted_products == 1 && $this->general_settings->promoted_products == 1 && !empty($promoted_products)): ?>
                <div class="col-12 section section-promoted">
                    <!-- promoted products -->
                    <?php $this->load->view("product/_featured_products"); ?>
                </div>
            <?php endif; ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'featured_products']); ?>

            <?php if ($this->general_settings->index_latest_products == 1 && !empty($latest_products)): ?>
                <div class="col-12 section section-latest-products">
                    <h3 class="title">
                        <a href="<?= generate_url('products'); ?>"><?= trans("new_arrivals"); ?></a>
                    </h3>
                    <p class="title-exp"><?php echo trans("latest_products_exp"); ?></p>
                    <div class="row row-product">
                        <!--print products-->
                        <?php foreach ($latest_products as $product): ?>
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'new_arrivals']); ?>

            <?php $this->load->view('product/_index_category_products', ['index_categories' => $index_categories]); ?>

            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_2", "class" => ""]); ?>
                </div>
            </div>
            <?php if ($this->general_settings->index_blog_slider == 1 && !empty($blog_slider_posts)): ?>
                <div class="col-12 section section-blog m-0">
                    <h3 class="title">
                        <a href="<?= generate_url('blog'); ?>"><?= trans("latest_blog_posts"); ?></a>
                    </h3>
                    <p class="title-exp"><?php echo trans("latest_blog_posts_exp"); ?></p>
                    <div class="row-custom">
                        <!-- main slider -->
                        <?php $this->load->view("blog/_blog_slider", ['blog_slider_posts' => $blog_slider_posts]); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Wrapper End-->





