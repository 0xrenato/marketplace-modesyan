<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!empty($payment_gateway) && $payment_gateway->name_key == "flutterwave"):
    $customer = get_cart_customer_data(); ?>
    <form>
        <script src="https://checkout.flutterwave.com/v3.js"></script>
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
            <button type="button" onClick="makePayment()" class="btn btn-lg btn-payment btn-flutterwave"><?= trans("pay"); ?>&nbsp;<?= price_decimal($total_amount, $currency); ?></button>
        </div>
    </form>
    <?php $consumer_mac = !empty($this->input->ip_address()) ? $this->input->ip_address() : uniqid();
    $consumer_id = $this->auth_check ? $this->auth_user->id : 0; ?>
    <script>
        function makePayment() {
            FlutterwaveCheckout({
                public_key: "<?= $payment_gateway->public_key;?>",
                tx_ref: "<?= $mds_payment_token; ?>",
                amount: <?= $total_amount; ?>,
                currency: "<?= $currency; ?>",
                payment_options: "card, mobilemoneyghana, ussd",
                redirect_url: "<?= base_url(); ?>flutterwave-payment-post",
                meta: {
                    consumer_id: <?= $consumer_id; ?>,
                    consumer_mac: "<?= $consumer_mac; ?>",
                },
                customer: {
                    email: "<?= !empty($customer) ? $customer->email : ''; ?>",
                    phone_number: "<?=  !empty($customer) ? $customer->phone_number : ''; ?>",
                    name: "<?=  !empty($customer) ? $customer->first_name . ' ' . $customer->last_name : ''; ?>"
                },
                callback: function (data) {
                },
                onclose: function () {
                },
                customizations: {
                    title: "<?= $this->general_settings->application_name; ?>",
                    description: "Payment for items in cart",
                    logo: "<?= get_logo($this->general_settings); ?>",
                },
            });
        }
    </script>
<?php endif; ?>