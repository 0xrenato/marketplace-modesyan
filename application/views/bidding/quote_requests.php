<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo $title; ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>
                        <div class="table-responsive">
                            <table class="table table-quote_requests table-striped">
                                <thead>
                                <tr>
                                    <th scope="col"><?php echo trans("quote"); ?></th>
                                    <th scope="col"><?php echo trans("product"); ?></th>
                                    <th scope="col"><?php echo trans("seller"); ?></th>
                                    <th scope="col"><?php echo trans("status"); ?></th>
                                    <th scope="col"><?php echo trans("sellers_bid"); ?></th>
                                    <th scope="col"><?php echo trans("updated"); ?></th>
                                    <th scope="col"><?php echo trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($quote_requests)): ?>
                                    <?php foreach ($quote_requests as $quote_request): ?>
                                        <tr>
                                            <td>#<?php echo $quote_request->id; ?></td>
                                            <td>
                                                <?php $product = get_product($quote_request->product_id);
                                                if (!empty($product)): ?>
                                                    <div class="table-item-product">
                                                        <div class="left">
                                                            <div class="img-table">
                                                                <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                                    <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                                <h3 class="table-product-title"><?php echo $quote_request->product_title; ?></h3>
                                                            </a>
                                                            <?php echo trans("quantity") . ": " . $quote_request->product_quantity; ?>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <h3 class="table-product-title"><?php echo $quote_request->product_title; ?></h3>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php $seller = get_user($quote_request->seller_id);
                                                if (!empty($seller)): ?>
                                                    <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="font-600">
                                                        <?= get_shop_name($seller); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo trans($quote_request->status); ?></td>
                                            <td>
                                                <?php if ($quote_request->status != 'new_quote_request' && $quote_request->price_offered != 0): ?>
                                                    <div class="table-seller-bid">
                                                        <p><strong><?= price_formatted(@convert_currency_by_exchange_rate($quote_request->price_offered, $this->selected_currency->exchange_rate), $this->selected_currency->code); ?></strong></p>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo time_ago($quote_request->updated_at); ?></td>
                                            <td>
                                                <?php if ($quote_request->status == 'pending_quote'): ?>
                                                    <?php echo form_open('accept-quote-post'); ?>
                                                    <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-info btn-table-option"><?php echo trans("accept_quote"); ?></button>
                                                    <?php echo form_close(); ?>

                                                    <?php echo form_open('reject-quote-post'); ?>
                                                    <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-secondary btn-table-option"><?php echo trans("reject_quote"); ?></button>
                                                    <?php echo form_close(); ?>

                                                <?php elseif ($quote_request->status == 'pending_payment'): ?>
                                                    <?php echo form_open('add-to-cart-quote'); ?>
                                                    <input type="hidden" name="id" class="form-control" value="<?php echo $quote_request->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-info btn-table-option"><i class="icon-cart"></i>&nbsp;<?php echo trans("add_to_cart"); ?></button>
                                                    <?php echo form_close(); ?>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-sm btn-danger btn-table-option btn-delete-quote" onclick="delete_quote_request(<?php echo $quote_request->id; ?>,'<?php echo trans("confirm_quote_request"); ?>');"><?php echo trans("delete_quote"); ?></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (empty($quote_requests)): ?>
                            <p class="text-center">
                                <?php echo trans("no_records_found"); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($quote_requests)): ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $num_rows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

