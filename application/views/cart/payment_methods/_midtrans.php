<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!empty($payment_gateway) && $payment_gateway->name_key == "midtrans"):
    require_once(APPPATH . 'third_party/midtrans/vendor/autoload.php');
    $show_midtrans = true;
    try {
        \Midtrans\Config::$serverKey = $payment_gateway->secret_key;
        if ($payment_gateway->environment == "production") {
            \Midtrans\Config::$isProduction = true;
        } else {
            \Midtrans\Config::$isProduction = false;
        }
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $customer = get_cart_customer_data();
        $gross_amount = intval($total_amount);
        $params = array(
            'transaction_details' => array(
                'order_id' => $mds_payment_token,
                'gross_amount' => $gross_amount
            ),
            'customer_details' => array(
                'first_name' => !empty($customer->first_name) ? $customer->first_name : '',
                'last_name' => !empty($customer->last_name) ? $customer->last_name : '',
                'email' => !empty($customer->email) ? $customer->email : '',
                'phone' => !empty($customer->phone_number) ? $customer->phone_number : '',
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    } catch (Exception $ex) {
        $show_midtrans = false; ?>
        <div class="alert alert-danger" role="alert">
            There was a problem starting Midtrans! Please make sure you select the correct mode and check your API keys again.
        </div>
    <?php } ?>
    <?php if ($show_midtrans == true):
    if ($payment_gateway->environment == "production"):?>
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?= $payment_gateway->public_key; ?>"></script>
    <?php else: ?>
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $payment_gateway->public_key; ?>"></script>
    <?php endif; ?>
    <div id="payment-button-container" class="payment-button-cnt">
        <div class="payment-icons-container">
            <label class="payment-icons">
                <?php $logos = @explode(',', $payment_gateway->logos);
                if (!empty($logos) && item_count($logos) > 0):
                    foreach ($logos as $logo): ?>
                        <img src="<?php echo base_url(); ?>assets/img/payment/<?= html_escape(trim($logo)); ?>.svg" alt="<?= html_escape(trim($logo)); ?>">
                    <?php endforeach;
                endif; ?>
            </label>
        </div>
        <p class="p-complete-payment text-muted"><?php echo trans("msg_complete_payment"); ?></p>
        <button type="button" id="pay-button" class="btn btn-lg btn-payment btn-midtrans"><?= trans("pay"); ?>&nbsp;<?= price_decimal($total_amount, $currency); ?></button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        document.getElementById('pay-button').onclick = function () {
            snap.pay("<?=!empty($snapToken) ? $snapToken : ''; ?>", {
                enabledPayments: ["credit_card"],
                onSuccess: function (result) {
                    if (result.status_code == 200) {
                        var data_array = {
                            'transaction_id': result.transaction_id,
                            'order_id': result.order_id,
                            'currency': '<?= $currency; ?>',
                            'payment_amount': '<?= price_decimal($total_amount, $currency); ?>',
                            'payment_status': result.transaction_status,
                            'mds_payment_type': '<?= $mds_payment_type; ?>',
                            'sys_lang_id': mds_config.sys_lang_id
                        };
                        data_array[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>" + "midtrans-payment-post",
                            data: data_array,
                            success: function (response) {
                                var obj = JSON.parse(response);
                                if (obj.result == 1) {
                                    window.location.href = obj.redirect_url;
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        alert(result.status_message);
                    }
                },
                onPending: function (result) {
                    alert(result.status_message);
                },
                onError: function (result) {
                    alert(result.status_message);
                }
            });
        };
    </script>
<?php endif;
endif; ?>