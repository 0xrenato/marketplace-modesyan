<?php defined('BASEPATH') or exit('No direct script access allowed');
$total_amount = $total_amount * 100;
if (!empty($payment_gateway) && $payment_gateway->name_key == "paystack"):
    $customer = get_cart_customer_data(); ?>
    <div class="row">
        <div class="col-12">
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>

    <form>
        <script src="https://js.paystack.co/v1/inline.js"></script>
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
            <p class="p-complete-payment"><?php echo trans("msg_complete_payment"); ?></p>
            <button type="button" class="btn btn-lg btn-payment btn-paystack" onclick="payWithPaystack()"><?= trans("pay"); ?>&nbsp;<?= price_formatted($total_amount, $currency); ?></button>
        </div>
    </form>

    <!-- place below the html form -->
    <script>
        function payWithPaystack() {
            var handler = PaystackPop.setup({
                key: '<?= $payment_gateway->public_key; ?>',
                email: '<?= !empty($customer) ? $customer->email : ""; ?>',
                amount: '<?= $total_amount; ?>',
                ref: '<?= generate_token(); ?>',
                callback: function (response) {
                    var data = {
                        'payment_id': response.reference,
                        'currency': '<?= $currency; ?>',
                        'payment_amount': '<?php echo $total_amount; ?>',
                        'payment_status': response.status,
                        'mds_payment_type': '<?= $mds_payment_type; ?>',
                        'sys_lang_id': mds_config.sys_lang_id
                    };
                    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>paystack-payment-post",
                        data: data,
                        success: function (response) {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                window.location.href = obj.redirect_url;
                            } else {
                                location.reload();
                            }
                        }
                    });
                },
            });
            handler.openIframe();
        }
    </script>
<?php endif; ?>
