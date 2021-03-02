<?php defined('BASEPATH') or exit('No direct script access allowed');
if (!empty($payment_gateway) && $payment_gateway->name_key == "paypal"): ?>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= $payment_gateway->public_key; ?>&currency=<?= $currency; ?>"></script>
    <div class="row">
        <div class="col-12">
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>
    <div id="payment-button-container" class="payment-button-cnt">
        <div id="paypal-button-container" style="max-width: 340px;margin: 0 auto"></div>
        <div class="col-12 paypal-loader hidden">
            <div class="row">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <strong class="payment-loader-text"><?php echo trans("processing"); ?></strong>
                </div>
            </div>
        </div>
    </div>
    <?php $price = str_replace('.00', '', $total_amount); ?>
    <script>
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $price; ?>'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    $('.paypal-loader').show();
                    var data_array = {
                        'payment_id': data.orderID,
                        'currency': '<?= $currency; ?>',
                        'payment_amount': '<?= $price; ?>',
                        'payment_status': details.status,
                        'mds_payment_type': '<?php echo $mds_payment_type; ?>',
                        'sys_lang_id': mds_config.sys_lang_id
                    };
                    data_array[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>paypal-payment-post",
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
                });
            },
            onError: function (error) {
                alert(error);
            }
        }).render('#paypal-button-container');
    </script>
<?php endif; ?>

<style>
    .paypal-loader .spinner {
        margin-bottom: 0 !important;
    }

    .payment-loader-text {
        font-size: 13px;
        font-weight: 600;
    }
</style>
