<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view("profile/_cover_image"); ?>
    <div id="wrapper">
        <div class="container">
            <?php if (empty($user->cover_image)): ?>
                <div class="row">
                    <div class="col-12">
                        <nav class="nav-breadcrumb" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo trans("wishlist"); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-12">
                    <div class="profile-page-top">
                        <!-- load profile details -->
                        <?php $this->load->view("profile/_profile_user_info"); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php $this->load->view("profile/_profile_tabs"); ?>
                </div>
                <div class="col-12">
                    <div class="profile-tab-content">
                        <div class="row row-product-items row-product">
                            <?php if (!empty($products)):
                                foreach ($products as $product): ?>
                                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                                    </div>
                                <?php endforeach;
                            else:?>
                                <div class="col-12">
                                    <p class="text-center text-muted"><?php echo trans("no_products_found"); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="product-list-pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                    <div class="row-custom">
                        <!--Include banner-->
                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>