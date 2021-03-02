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
                <div class="col-sm-12 col-md-3">
                    <div class="row-custom">
                        <!-- load profile nav -->
                        <?php $this->load->view("order/_order_tabs"); ?>
                    </div>
                </div>

                <div class="col-sm-12 col-md-9">
                    <div class="row">
                        <div class="col-12">
                            <!-- include message block -->
                            <?php $this->load->view('product/_messages'); ?>
                        </div>
                    </div>

                    <div class="order-details-container">
                        <div class="order-head">
                            <h2 class="title"><?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?></h2>
                        </div>
                        <div class="order-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <?php echo trans("status"); ?>
                                        </div>
                                        <div class="col-9">
                                            <?php if ($order->status == 1): ?>
                                                <strong><?php echo trans("completed"); ?></strong>
                                            <?php else: ?>
                                                <strong><?php echo trans("order_processing"); ?></strong>
                                            <?php endif; ?>

                                            <a href="<?php echo lang_base_url(); ?>invoice/<?php echo $order->order_number; ?>" target="_blank" class="btn btn-sm btn-info btn-sale-options btn-view-invoice"><i class="icon-text-o"></i>&nbsp;<?php echo trans('view_invoice'); ?></a>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <?php echo trans("payment_status"); ?>
                                        </div>
                                        <div class="col-9">
                                            <?php echo trans($order->payment_status); ?>
                                            <?php if ($order->payment_method == "Bank Transfer" && $order->payment_status == "awaiting_payment"):
                                                if (isset($last_bank_transfer)):?>
                                                    <?php if ($last_bank_transfer->status == "pending"): ?>
                                                        <span class="text-info">(<?php echo trans("pending"); ?>)</span>
                                                    <?php elseif ($last_bank_transfer->status == "declined"): ?>
                                                        <span class="text-danger">(<?php echo trans("bank_transfer_declined"); ?>)</span>
                                                        <button type="button" class="btn btn-sm btn-secondary color-white m-l-15" data-toggle="modal" data-target="#reportPaymentModal"><?php echo trans("report_bank_transfer"); ?></button>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-secondary color-white m-l-15" data-toggle="modal" data-target="#reportPaymentModal"><?php echo trans("report_bank_transfer"); ?></button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-sm btn-success color-white" data-toggle="modal" data-target="#bankAccountsModal"><?php echo trans("bank_accounts"); ?></button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <?php echo trans("payment_method"); ?>
                                        </div>
                                        <div class="col-9">
                                            <?= get_payment_method($order->payment_method); ?>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <?php echo trans("date"); ?>
                                        </div>
                                        <div class="col-9">
                                            <?php echo formatted_date($order->created_at); ?>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                            <?php echo trans("updated"); ?>
                                        </div>
                                        <div class="col-9">
                                            <?php echo time_ago($order->updated_at); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php $shipping = get_order_shipping($order->id);
                            if (!empty($shipping)):?>
                                <div class="row shipping-container">
                                    <div class="col-md-12 col-lg-6 m-b-sm-15">
                                        <h3 class="block-title"><?php echo trans("shipping_address"); ?></h3>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("first_name"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_first_name); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("last_name"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_last_name); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("email"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_email); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("phone_number"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_phone_number); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("address"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_address); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("country"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_country); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("state"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_state); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("city"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_city); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("zip_code"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->shipping_zip_code); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        <h3 class="block-title"><?php echo trans("billing_address"); ?></h3>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("first_name"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_first_name); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("last_name"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_last_name); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("email"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_email); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("phone_number"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_phone_number); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("address"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_address); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("country"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_country); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("state"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_state); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("city"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_city); ?>
                                            </div>
                                        </div>
                                        <div class="row shipping-row-item">
                                            <div class="col-5">
                                                <?php echo trans("zip_code"); ?>
                                            </div>
                                            <div class="col-7">
                                                <?= html_escape($shipping->billing_zip_code); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php $is_order_has_physical_product = false; ?>
                            <div class="row table-orders-container">
                                <div class="col-6 col-table-orders">
                                    <h3 class="block-title"><?php echo trans("products"); ?></h3>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-orders">
                                            <thead>
                                            <tr>
                                                <th scope="col"><?php echo trans("product"); ?></th>
                                                <th scope="col"><?php echo trans("status"); ?></th>
                                                <th scope="col"><?php echo trans("updated"); ?></th>
                                                <th scope="col"><?php echo trans("options"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($order_products as $item):
                                                if ($item->product_type == 'physical') {
                                                    $is_order_has_physical_product = true;
                                                } ?>
                                                <tr>
                                                    <td style="width: 50%">
                                                        <div class="table-item-product">
                                                            <div class="left">
                                                                <div class="img-table">
                                                                    <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                                                        <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="right">
                                                                <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank" class="table-product-title">
                                                                    <?php echo html_escape($item->product_title); ?>
                                                                </a>
                                                                <p class="m-b-15">
                                                                    <span><?php echo trans("seller"); ?>:</span>
                                                                    <?php $seller = get_user($item->seller_id); ?>
                                                                    <?php if (!empty($seller)): ?>
                                                                        <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="table-product-title">
                                                                            <strong class="font-600"><?php echo get_shop_name($seller); ?></strong>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </p>
                                                                <p><span class="span-product-dtl-table"><?php echo trans("unit_price"); ?>:</span><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></p>
                                                                <p><span class="span-product-dtl-table"><?php echo trans("quantity"); ?>:</span><?php echo $item->product_quantity; ?></p>
                                                                <?php if (!empty($item->product_vat)): ?>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("vat"); ?>&nbsp;(<?php echo $item->product_vat_rate; ?>%):</span><?php echo price_formatted($item->product_vat, $item->product_currency); ?></p>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("total"); ?>:</span><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></p>
                                                                <?php else: ?>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("total"); ?>:</span><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <strong class="no-wrap"><?php echo trans($item->order_status) ?></strong>
                                                    </td>
                                                    <td style="width: 15%;">
                                                        <?php if ($item->product_type == 'physical') {
                                                            echo time_ago($item->updated_at);
                                                        } ?>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        <?php if ($item->order_status == "shipped"): ?>
                                                            <button type="submit" class="btn btn-sm btn-custom" onclick="approve_order_product('<?php echo $item->id; ?>','<?php echo trans("confirm_approve_order"); ?>');"><i class="icon-check"></i><?php echo trans("confirm_order_received"); ?></button>
                                                            <small class="text-confirm-order-table"><?php echo trans("confirm_order_received_exp"); ?></small>
                                                        <?php elseif ($item->order_status == "completed"): ?>
                                                            <?php if ($item->product_type == 'digital'):
                                                                $digital_sale = get_digital_sale_by_order_id($item->buyer_id, $item->product_id, $item->order_id);
                                                                if (!empty($digital_sale)):
                                                                    if ($item->listing_type == 'license_key'):?>
                                                                        <div class="row-custom">
                                                                            <?php echo form_open('download-purchased-digital-file-post'); ?>
                                                                            <input type="hidden" name="sale_id" value="<?php echo $digital_sale->id; ?>">
                                                                            <button name="submit" value="license_certificate" class="btn btn-md btn-custom no-wrap"><i class="icon-download-solid"></i><?php echo trans("download_license_key"); ?></button>
                                                                            <?php echo form_close(); ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="row-custom">
                                                                            <?php echo form_open('download-purchased-digital-file-post'); ?>
                                                                            <input type="hidden" name="sale_id" value="<?php echo $digital_sale->id; ?>">
                                                                            <div class="btn-group btn-group-download m-b-15">
                                                                                <button type="button" class="btn btn-md btn-custom dropdown-toggle" data-toggle="dropdown">
                                                                                    <i class="icon-download-solid"></i><?php echo trans("download"); ?>&nbsp;&nbsp;<i class="icon-arrow-down m-0"></i>
                                                                                </button>
                                                                                <div class="dropdown-menu">
                                                                                    <button name="submit" value="main_files" class="dropdown-item"><?php echo trans("main_files"); ?></button>
                                                                                    <button name="submit" value="license_certificate" class="dropdown-item"><?php echo trans("license_certificate"); ?></button>
                                                                                </div>
                                                                            </div>
                                                                            <?php echo form_close(); ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endif;
                                                            endif; ?>

                                                            <?php if ($this->general_settings->reviews == 1 && $item->seller_id != $item->buyer_id): ?>
                                                                <div class="row-custom">
                                                                    <div class="rate-product">
                                                                        <p class="p-rate-product"><?php echo trans("rate_this_product"); ?></p>
                                                                        <div class="rating-stars">
                                                                            <?php $review = get_review($item->product_id, $this->auth_user->id); ?>
                                                                            <label class="label-star label-star-open-modal" data-star="5" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 5) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal" data-star="4" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 4) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal" data-star="3" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 3) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal" data-star="2" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 2) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                            <label class="label-star label-star-open-modal" data-star="1" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 1) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                                <?php if ($item->product_type == "physical"): ?>
                                                <tr class="tr-shipping">
                                                    <td colspan="4">
                                                        <div class="order-shipping-tracking-number">
                                                            <p><strong><?php echo trans("shipping") ?></strong></p>
                                                            <p class="font-600 m-t-5"><?= trans("shipping_method") ?>:&nbsp;<?= html_escape($item->shipping_method); ?></p>
                                                            <?php if ($item->order_status == "shipped"): ?>
                                                                <p class="font-600 m-t-15"><?= trans("order_has_been_shipped"); ?></p>
                                                                <p><?php echo trans("tracking_code") ?>:&nbsp;<?php echo html_escape($item->shipping_tracking_number); ?></p>
                                                                <p class="m-0"><?php echo trans("tracking_url") ?>: <a href="<?php echo html_escape($item->shipping_tracking_url); ?>" target="_blank" class="link-underlined"><?php echo html_escape($item->shipping_tracking_url); ?></a></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="tr-shipping-seperator">
                                                    <td colspan="4"></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="order-total">
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?php echo trans("subtotal"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600"><?php echo price_formatted($order->price_subtotal, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                        <?php if (!empty($order->price_vat)): ?>
                                            <div class="row">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("vat"); ?>
                                                </div>
                                                <div class="col-6 col-right">
                                                    <strong class="font-600"><?php echo price_formatted($order->price_vat, $order->price_currency); ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($is_order_has_physical_product): ?>
                                            <div class="row">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("shipping"); ?>
                                                </div>
                                                <div class="col-6 col-right">
                                                    <strong class="font-600"><?php echo price_formatted($order->price_shipping, $order->price_currency); ?></strong>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row-seperator"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?php echo trans("total"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <?php $price_second_currency = "";
                                                $transaction = $this->transaction_model->get_transaction_by_order_id($order->id);
                                                if (!empty($transaction) && $transaction->currency != $order->price_currency):
                                                    $price_second_currency = price_currency_format($transaction->payment_amount, $transaction->currency);
                                                endif; ?>
                                                <strong class="font-600">
                                                    <?php echo price_formatted($order->price_total, $order->price_currency);
                                                    if (!empty($price_second_currency)):?>
                                                        <br><span style="font-weight: 400;white-space: nowrap;">(<?= trans("paid"); ?>:&nbsp;<?= $price_second_currency; ?>&nbsp;<?= $transaction->currency; ?>)</span>
                                                    <?php endif; ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($shipping)): ?>
                        <p class="text-confirm-order">*<?php echo trans("confirm_order_received_warning"); ?></p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper End-->

    <!-- Modal -->
    <div class="modal fade" id="reportPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <!-- form start -->
                <?php echo form_open_multipart('bank-transfer-payment-report-post'); ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("report_bank_transfer"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_number" class="form-control form-input" value="<?php echo $order->order_number; ?>">
                    <div class="form-group">
                        <label><?php echo trans("payment_note"); ?></label>
                        <textarea name="payment_note" class="form-control form-textarea" maxlength="499"></textarea>
                    </div>
                    <div class="form-group">
                        <label><?php echo trans("receipt"); ?>
                            <small>(.png, .jpg, .jpeg)</small>
                        </label>
                        <div>
                            <a class='btn btn-md btn-secondary btn-file-upload'>
                                <?php echo trans('select_image'); ?>
                                <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));">
                            </a>
                            <br>
                            <span class='badge badge-info' id="upload-file-info"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-custom float-right"><?php echo trans("submit"); ?></button>
                </div>
                <?php echo form_close(); ?><!-- form end -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="bankAccountsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("bank_accounts"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted"><?= trans("bank_accounts_exp"); ?></p>
                    <?php echo $this->payment_settings->bank_transfer_accounts; ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('partials/_modal_rate_product'); ?>