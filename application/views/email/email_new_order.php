<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("email_text_thank_for_order")]); ?>
<table role="presentation" class="main">
    <?php if (!empty($order)): ?>
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("email_text_thank_for_order"); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                                <p style='text-align: left;color: #555;'>
                                    <?php echo trans("email_text_new_order"); ?>
                                </p><br>
                                <h2 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("order_information"); ?></h2>
                                <p style="color: #555;">
                                    <?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?><br>
                                    <?php echo trans("payment_status"); ?>:&nbsp;<?php echo trans($order->payment_status); ?><br>
                                    <?php echo trans("payment_method"); ?>:&nbsp;<?= get_payment_method($order->payment_method); ?>
                                    <br>
                                    <?php echo trans("date"); ?>:&nbsp;<?php echo formatted_date($order->created_at); ?><br>
                                </p>
                            </div>

                            <?php $shipping = get_order_shipping($order->id);
                            if (!empty($shipping)):?>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                                    <tr>
                                        <td>
                                            <h3 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("shipping_address"); ?></h3>
                                            <p style="color: #555; padding-right: 10px;">
                                                <?php echo trans("first_name"); ?>:&nbsp;<?php echo $shipping->shipping_first_name; ?><br>
                                                <?php echo trans("last_name"); ?>:&nbsp;<?php echo $shipping->shipping_last_name; ?><br>
                                                <?php echo trans("email"); ?>:&nbsp;<?php echo $shipping->shipping_email; ?><br>
                                                <?php echo trans("phone_number"); ?>:&nbsp;<?php echo $shipping->shipping_phone_number; ?><br>
                                                <?php echo trans("address"); ?>:&nbsp;<?php echo $shipping->shipping_address; ?><br>
                                                <?php echo trans("country"); ?>:&nbsp;<?php echo $shipping->shipping_country; ?><br>
                                                <?php echo trans("state"); ?>:&nbsp;<?php echo $shipping->shipping_state; ?><br>
                                                <?php echo trans("city"); ?>:&nbsp;<?php echo $shipping->shipping_city; ?><br>
                                                <?php echo trans("zip_code"); ?>:&nbsp;<?php echo $shipping->shipping_zip_code; ?><br>
                                            </p>
                                        </td>
                                        <td>
                                            <h3 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("billing_address"); ?></h3>
                                            <p style="color: #555; padding-right: 10px;">
                                                <?php echo trans("first_name"); ?>:&nbsp;<?php echo $shipping->billing_first_name; ?><br>
                                                <?php echo trans("last_name"); ?>:&nbsp;<?php echo $shipping->billing_last_name; ?><br>
                                                <?php echo trans("email"); ?>:&nbsp;<?php echo $shipping->billing_email; ?><br>
                                                <?php echo trans("phone_number"); ?>:&nbsp;<?php echo $shipping->billing_phone_number; ?><br>
                                                <?php echo trans("address"); ?>:&nbsp;<?php echo $shipping->billing_address; ?><br>
                                                <?php echo trans("country"); ?>:&nbsp;<?php echo $shipping->billing_country; ?><br>
                                                <?php echo trans("state"); ?>:&nbsp;<?php echo $shipping->billing_state; ?><br>
                                                <?php echo trans("city"); ?>:&nbsp;<?php echo $shipping->billing_city; ?><br>
                                                <?php echo trans("zip_code"); ?>:&nbsp;<?php echo $shipping->billing_zip_code; ?><br>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            <?php endif; ?>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">
                                <tr>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("product"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("unit_price"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("quantity"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("vat"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("total"); ?></th>
                                </tr>
                                <?php foreach ($order_products as $item): ?>
                                    <tr>
                                        <td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;"><?php echo $item->product_title; ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo $item->product_quantity; ?></td>
                                        <?php if (!empty($order->price_vat)): ?>
                                            <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">
                                                <?php if (!empty($item->product_vat)): ?>
                                                    <?php echo price_formatted($item->product_vat, $item->product_currency); ?>&nbsp;(<?php echo $item->product_vat_rate; ?>%)
                                                <?php endif; ?>
                                            </td>
                                        <?php else: ?>
                                            <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>
                                        <?php endif; ?>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: right;margin-top: 40px;">
                                <tr>
                                    <td style="width: 70%"><?php echo trans("subtotal"); ?></td>
                                    <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_subtotal, $order->price_currency); ?></td>
                                </tr>
                                <?php if (!empty($order->price_vat)): ?>
                                    <tr>
                                        <td style="width: 70%"><?php echo trans("vat"); ?></td>
                                        <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_vat, $order->price_currency); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="width: 70%"><?php echo trans("shipping"); ?></td>
                                    <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_shipping, $order->price_currency); ?></td>
                                </tr>
                                <tr>
                                    <?php $price_second_currency = "";
                                    $transaction = $this->transaction_model->get_transaction_by_order_id($order->id);
                                    if (!empty($transaction) && $transaction->currency != $order->price_currency):
                                        $price_second_currency = price_currency_format($transaction->payment_amount, $transaction->currency);
                                    endif; ?>
                                    <td style="width: 70%;font-weight: bold"><?php echo trans("total"); ?></td>
                                    <td style="width: 30%;padding-right: 15px;font-weight: 600;">
                                        <?php echo price_formatted($order->price_total, $order->price_currency);
                                        if (!empty($price_second_currency)):?>
                                            <br><span style="font-weight: 400;white-space: nowrap;">(<?= trans("paid"); ?>:&nbsp;<?= $price_second_currency; ?>&nbsp;<?= $transaction->currency; ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                            <?php if ($order->buyer_type != 'guest'): ?>
                                <p style='text-align: center;margin-top: 40px;'>
                                    <a href="<?php echo generate_url("order_details") . '/' . $order->order_number; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #09b1ba;color: #ffffff !important; border-radius: 3px;'>
                                        <?php echo trans("see_order_details"); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php $this->load->view('email/_footer'); ?>
