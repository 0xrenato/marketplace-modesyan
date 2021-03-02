<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("sale"); ?>:&nbsp;#<?php echo $order->order_number; ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row m-b-30">
            <div class="col-sm-12">
                <div class="line-detail">
                    <span><?php echo trans("status"); ?></span>
                    <?php $order_status = 1;
                    foreach ($order_products as $item):
                        if ($item->order_status != 'completed') {
                            $order_status = 0;
                        }
                    endforeach;
                    if ($order_status == 1): ?>
                        <label class="label label-default"><?= trans("completed"); ?></label>
                    <?php else: ?>
                        <label class="label label-success"><?= trans("order_processing"); ?></label>
                    <?php endif; ?>
                    <a href="<?php echo lang_base_url(); ?>invoice/<?php echo $order->order_number; ?>?np=seller" target="_blank" class="btn btn-sm btn-info btn-sale-options btn-view-invoice"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<?php echo trans('view_invoice'); ?></a>
                </div>
                <div class="line-detail">
                    <span><?= trans("payment_status"); ?></span>
                    <strong class="font-600"><?= trans($order->payment_status); ?></strong>
                </div>
                <div class="line-detail">
                    <span><?= trans("payment_method"); ?></span>
                    <?= get_payment_method($order->payment_method); ?>
                </div>
                <div class="line-detail">
                    <span><?= trans("date"); ?></span>
                    <?= formatted_date($order->created_at); ?>
                </div>

                <div class="line-detail">
                    <span><?= trans("updated"); ?></span>
                    <?= time_ago($order->updated_at); ?>
                </div>
            </div>
        </div>
        <?php $shipping = get_order_shipping($order->id);
        if (!empty($shipping)):?>
            <div class="row m-b-30">
                <div class="col-sm-12 col-md-6">
                    <h3 class="block-title"><?php echo trans("shipping_address"); ?></h3>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("first_name"); ?></span>
                        <?= html_escape($shipping->shipping_first_name); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("last_name"); ?></span>
                        <?= html_escape($shipping->shipping_last_name); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("email"); ?></span>
                        <?= html_escape($shipping->shipping_email); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("phone_number"); ?></span>
                        <?= html_escape($shipping->shipping_phone_number); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("address"); ?></span>
                        <?= html_escape($shipping->shipping_address); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("country"); ?></span>
                        <?= html_escape($shipping->shipping_country); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("state"); ?></span>
                        <?= html_escape($shipping->shipping_state); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("city"); ?></span>
                        <?= html_escape($shipping->shipping_city); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("zip_code"); ?></span>
                        <?= html_escape($shipping->shipping_zip_code); ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3 class="block-title"><?php echo trans("billing_address"); ?></h3>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("first_name"); ?></span>
                        <?= html_escape($shipping->billing_first_name); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("last_name"); ?></span>
                        <?= html_escape($shipping->billing_last_name); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("email"); ?></span>
                        <?= html_escape($shipping->billing_email); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("phone_number"); ?></span>
                        <?= html_escape($shipping->billing_phone_number); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("address"); ?></span>
                        <?= html_escape($shipping->billing_address); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("country"); ?></span>
                        <?= html_escape($shipping->billing_country); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("state"); ?></span>
                        <?= html_escape($shipping->billing_state); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("city"); ?></span>
                        <?= html_escape($shipping->billing_city); ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= trans("zip_code"); ?></span>
                        <?= html_escape($shipping->billing_zip_code); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <h3 class="block-title"><?php echo trans("products"); ?></h3>
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
                        <?php
                        $sale_subtotal = 0;
                        $sale_vat = 0;
                        $sale_shipping = 0;
                        $sale_total = 0;
                        foreach ($order_products as $item):
                            if ($item->seller_id == $this->auth_user->id):
                                $sale_subtotal += $item->product_unit_price * $item->product_quantity;
                                $sale_vat += $item->product_vat;
                                $sale_shipping = $item->seller_shipping_cost;
                                $sale_total += $item->product_total_price; ?>
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
                                    <td style="width: 10%; white-space: nowrap">
                                        <strong><?php echo trans($item->order_status) ?></strong>
                                    </td>
                                    <td style="width: 15%">
                                        <?php if ($item->product_type == 'physical') {
                                            echo time_ago($item->updated_at);
                                        } ?>
                                    </td>
                                    <td style="width: 25%">
                                        <?php if ($item->product_type != "digital"):
                                            if ($item->order_status == "completed"): ?>
                                                <strong class="font-600"><i class="icon-check"></i>&nbsp;<?php echo trans("approved"); ?></strong>
                                            <?php else: ?>
                                                <p class="m-b-5">
                                                    <button type="button" class="btn btn-md btn-block btn-success" data-toggle="modal" data-target="#updateStatusModal_<?php echo $item->id; ?>"><?php echo trans('update_order_status'); ?></button>
                                                </p>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                </tr>
                                <?php if ($item->product_type != "digital"): ?>
                                <tr class="tr-shipping">
                                    <td colspan="4">
                                        <div class="order-shipping-tracking-number">
                                            <p><strong><?php echo trans("shipping") ?></strong></p>
                                            <p class="font-600 m-t-5"><?= trans("shipping_method") ?>:&nbsp;<?= html_escape($item->shipping_method); ?></p>
                                            <?php if ($item->order_status == "shipped"): ?>
                                                <p class="font-600 m-t-15"><?= trans("order_has_been_shipped"); ?></p>
                                                <p><?php echo trans("tracking_code") ?>:&nbsp;<?php echo html_escape($item->shipping_tracking_number); ?></p>
                                                <p class="m-0"><?php echo trans("tracking_url") ?>: <a href="<?php echo html_escape($item->shipping_tracking_url); ?>" target="_blank" class="link-underlined"><?php echo html_escape($item->shipping_tracking_url); ?></a></p>
                                            <?php else: ?>
                                                <p><?= trans("order_not_yet_shipped") . trans("warning_add_order_tracking_code"); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tr-shipping-seperator">
                                    <td colspan="4"></td>
                                </tr>
                            <?php endif;
                            endif;
                        endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="order-total">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?php echo trans("subtotal"); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?php echo price_formatted($sale_subtotal, $order->price_currency); ?></strong>
                        </div>
                    </div>
                    <?php if (!empty($sale_vat)): ?>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-left">
                                <?php echo trans("vat"); ?>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-right">
                                <strong><?php echo price_formatted($sale_vat, $order->price_currency); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?php echo trans("shipping"); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?php echo price_formatted($sale_shipping, $order->price_currency); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 m-b-15">
                            <div class="row-seperator"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?php echo trans("total"); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?php echo price_formatted($sale_total + $sale_shipping, $order->price_currency); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php foreach ($order_products as $item):
    if ($item->seller_id == $this->auth_user->id):?>
        <div class="modal fade" id="updateStatusModal_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open('update-order-product-status-post'); ?>
                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("update_order_status"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('status'); ?></label>
                                    <select id="select_order_status" name="order_status" class="form-control custom-select" data-order-product-id="<?php echo $item->id; ?>">
                                        <?php if ($item->product_type == 'physical'): ?>
                                            <option value="order_processing" <?php echo ($item->order_status == 'order_processing') ? 'selected' : ''; ?>><?php echo trans("order_processing"); ?></option>
                                            <option value="shipped" <?php echo ($item->order_status == 'shipped') ? 'selected' : ''; ?>><?php echo trans("shipped"); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="row tracking-number-container <?= $item->order_status != 'shipped' ? 'display-none' : ''; ?>">
                                    <hr>
                                    <div class="col-12 text-center">
                                        <strong><?= trans("shipping"); ?></strong>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label><?= trans("tracking_code"); ?></label>
                                            <input type="text" name="shipping_tracking_number" class="form-control form-input" value="<?= html_escape($item->shipping_tracking_number); ?>" placeholder="<?= trans("tracking_code"); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><?= trans("tracking_url"); ?></label>
                                            <input type="text" name="shipping_tracking_url" class="form-control form-input" value="<?= html_escape($item->shipping_tracking_url); ?>" placeholder="<?= trans("tracking_url"); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" class="btn btn-md btn-success"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
        </div>
    <?php endif;
endforeach; ?>

<script>
    $(document).on("change", "#select_order_status", function () {
        var val = $(this).val();
        if (val == "shipped") {
            $(".tracking-number-container").show();
        } else {
            $(".tracking-number-container").hide();
        }
    });
</script>

