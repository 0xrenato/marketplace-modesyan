<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!empty($payment_gateway) && $payment_gateway->name_key == "stripe"):
    require_once "application/third_party/stripe/vendor/autoload.php";
    $total_amount = intval($total_amount * 100);
    //if JPY
    if ($currency == "JPY") {
        $total_amount = $total_amount / 100;
    }
    $show_stripe = true;
    try {
        \Stripe\Stripe::setApiKey($payment_gateway->secret_key);
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $total_amount,
            'currency' => $currency,
        ]);
        $clientSecret = !empty($intent->client_secret) ? $intent->client_secret : '';
        $this->session->set_userdata('mds_stripe_client_secret', $clientSecret);
    } catch (Exception $e) {
        $show_stripe = false; ?>
        <div class="alert alert-danger" role="alert">
            <?= $e->getMessage(); ?>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-12">
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>
    <?php if ($show_stripe == true): ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 stripe-checkout">
            <form id="payment-form">
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
                <div class="form-group">
                    <input type="text" name="name" id="sp_input_name" class="form-control shadow-sm" placeholder="<?= trans("full_name"); ?>">
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="sp_input_email" class="form-control shadow-sm" placeholder="<?= trans("email"); ?>">
                </div>
                <div class="form-group">
                    <div id="card-element" class="form-control input-card-element shadow-sm"></div>
                </div>
                <button id="submit" class="btn btn-primary" id="card-button">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <?= trans("pay"); ?>&nbsp;<?= price_formatted($total_amount, $currency); ?>
                </button>
            </form>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("<?= $payment_gateway->public_key; ?>");
        var elements = stripe.elements();
        var style = {
            base: {
                color: "#32325d",
                lineHeight: '38px',
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            },
        };
        var card = elements.create("card", {style: style});
        card.mount("#card-element");

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function (ev) {
            ev.preventDefault();
            var validation = true;
            var buyer_name = $("#sp_input_name").val();
            var buyer_email = $("#sp_input_email").val();
            if (buyer_name == null || buyer_name.trim() < 2) {
                $("#sp_input_name").addClass("is-invalid");
                return false;
            } else {
                $("#sp_input_name").removeClass("is-invalid");
            }
            if (buyer_email == null || buyer_email.trim() < 2) {
                $("#sp_input_email").addClass("is-invalid");
                return false;
            } else {
                $("#sp_input_email").removeClass("is-invalid");
            }
            $('.stripe-checkout #submit').prop("disabled", true);
            $('.stripe-checkout .spinner-border').css('display', 'inline-block');
            var clientSecret = "<?= $clientSecret; ?>";
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    type: 'card',
                    card: card,
                    billing_details: {
                        name: buyer_name,
                        email: buyer_email
                    }
                }
            }).then(function (result) {
                if (result.error) {
                    $('.stripe-checkout #submit').prop("disabled", false);
                    $('.stripe-checkout .spinner-border').css('display', 'none');
                    alert(result.error.message);
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        var data = {
                            'paymentObject': JSON.stringify(result.paymentIntent),
                            'sys_lang_id': mds_config.sys_lang_id
                        };
                        data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>stripe-payment-post",
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
                    }
                }
            });
        });

        $(document).on("input keyup paste change", "#payment-form input", function () {
            var val = $(this).val();
            if (val == null || val.trim() < 2) {
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-invalid");
            }
        });
    </script>
<?php endif;
endif; ?>
