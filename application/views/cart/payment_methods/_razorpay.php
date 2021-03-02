<?php defined('BASEPATH') or exit('No direct script access allowed');
$total_amount = intval($total_amount * 100);
if (!empty($payment_gateway) && $payment_gateway->name_key == "razorpay"):
    $ci =& get_instance();
    $ci->load->library('razorpay');
    $array = array(
        'receipt' => $mds_payment_token,
        'amount' => $total_amount,
        'currency' => $currency
    );
    $razorpay_order_id = $ci->razorpay->create_order($array);
    if (!empty($razorpay_order_id)): ?>
        <div class="row">
            <div class="col-12">
                <?php $this->load->view('product/_messages'); ?>
            </div>
        </div>
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
            <button type="button" id="rzp-button1" class="btn btn-lg btn-payment btn-razorpay"><?= trans("pay"); ?>&nbsp;<?= price_formatted($total_amount, $currency); ?></button>
        </div>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            var options = {
                "key": "<?= $payment_gateway->public_key; ?>",
                "amount": "<?= $total_amount; ?>",
                "currency": "<?= $currency; ?>",
                "name": "<?= $this->general_settings->application_name; ?>",
                "description": "<?php echo trans("pay"); ?>",
                "image": "<?= get_logo_email($this->general_settings); ?>",
                "order_id": "<?= $razorpay_order_id; ?>",
                "handler": function (response) {
                    var data_array = {
                        'payment_id': response.razorpay_payment_id,
                        'razorpay_order_id': response.razorpay_order_id,
                        'razorpay_signature': response.razorpay_signature,
                        'currency': '<?= $currency; ?>',
                        'payment_amount': '<?= $total_amount; ?>',
                        'payment_status': '',
                        'mds_payment_type': '<?= $mds_payment_type; ?>',
                        'sys_lang_id': mds_config.sys_lang_id
                    };
                    data_array[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>razorpay-payment-post",
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
                },
                "theme": {
                    "color": "#528FF0"
                }
            };
            var rzp1 = new Razorpay(options);
            document.getElementById('rzp-button1').onclick = function (e) {
                rzp1.open();
                e.preventDefault();
            }
        </script>
    <?php endif;
endif; ?>
