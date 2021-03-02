<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.min.js"></script>
<script>
    $(window).bind("load", function () {
        $("#payment-button-container").css("visibility", "visible");
    });
</script>

<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shopping-cart shopping-cart-shipping">
                    <div class="row">
                        <div class="col-sm-12 col-lg-8">
                            <div class="left">
                                <h1 class="cart-section-title"><?php echo trans("checkout"); ?></h1>
                                <?php if (!$this->auth_check): ?>
                                    <div class="row m-b-15">
                                        <div class="col-12 col-md-6">
                                            <p><?php echo trans("checking_out_as_guest"); ?></p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <p class="text-right"><?php echo trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link-underlined" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($cart_has_physical_product) && $this->product_settings->marketplace_shipping == 1 && $mds_payment_type == "sale"): ?>
                                    <div class="tab-checkout tab-checkout-closed">
                                        <a href="<?php echo generate_url("cart", "shipping"); ?>"><h2 class=" title">1.&nbsp;&nbsp;<?php echo trans("shipping_information"); ?></h2></a>
                                        <a href="<?php echo generate_url("cart", "shipping"); ?>" class="link-underlined"><?php echo trans("edit"); ?></a>
                                    </div>
                                <?php endif; ?>

                                <div class="tab-checkout tab-checkout-closed">
                                    <?php if ($mds_payment_type == "membership" || $mds_payment_type == "promote"): ?>
                                        <a href="<?php echo generate_url("cart", "payment_method"); ?>?payment_type=<?= $mds_payment_type; ?>"><h2 class="title">
                                                <?php if (!empty($cart_has_physical_product) && $mds_payment_type == "sale") {
                                                    echo '2.';
                                                } else {
                                                    echo '1.';
                                                } ?>
                                                &nbsp;<?php echo trans("payment_method"); ?></h2></a>
                                        <a href="<?php echo generate_url("cart", "payment_method"); ?>?payment_type=<?= $mds_payment_type; ?>" class="link-underlined"><?php echo trans("edit"); ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo generate_url("cart", "payment_method"); ?>"><h2 class=" title">
                                                <?php if (!empty($cart_has_physical_product) && $this->product_settings->marketplace_shipping == 1 && $mds_payment_type == "sale") {
                                                    echo '2.';
                                                } else {
                                                    echo '1.';
                                                } ?>
                                                &nbsp;<?php echo trans("payment_method"); ?></h2></a>
                                        <a href="<?php echo generate_url("cart", "payment_method"); ?>" class="link-underlined"><?php echo trans("edit"); ?></a>
                                    <?php endif; ?>
                                </div>

                                <div class="tab-checkout tab-checkout-open">
                                    <h2 class="title">
                                        <?php if (!empty($cart_has_physical_product) && $this->product_settings->marketplace_shipping == 1 && $mds_payment_type == "sale") {
                                            echo '3.';
                                        } else {
                                            echo '2.';
                                        } ?>&nbsp;
                                        <?php echo trans("payment"); ?>
                                    </h2>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php
                                            $data = array('total_amount' => $total_amount, 'currency' => $currency, 'mds_payment_type' => $mds_payment_type, 'cart_total' => $cart_total, 'mds_payment_token' => generate_token());
                                            if (!empty($cart_payment_method->payment_option)) {
                                                $data['payment_gateway'] = get_payment_gateway($cart_payment_method->payment_option);
                                            }
                                            if ($cart_payment_method->payment_option == "bank_transfer") {
                                                $this->load->view("cart/payment_methods/_bank_transfer", $data);
                                            } elseif ($this->auth_check && $cart_payment_method->payment_option == "cash_on_delivery") {
                                                $this->load->view("cart/payment_methods/_cash_on_delivery", $data);
                                            } else {
                                                $sess_data = new stdClass();
                                                $sess_data->mds_payment_token = $data['mds_payment_token'];
                                                $sess_data->currency = $data['currency'];
                                                $sess_data->total_amount = $data['total_amount'];
                                                $sess_data->payment_type = $mds_payment_type;
                                                $this->session->set_userdata('mds_payment_cart_data', $sess_data);
                                                //load view
                                                if (empty($cart_payment_method->payment_option)) {
                                                    redirect(generate_url('cart', 'payment_method'));
                                                    exit();
                                                }
                                                $this->load->view("cart/payment_methods/_" . $cart_payment_method->payment_option, $data);
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php if ($mds_payment_type == 'membership'):
                            $this->load->view("cart/_order_summary_membership");
                        elseif ($mds_payment_type == 'promote'):
                            $this->load->view("cart/_order_summary_promote");
                        else:
                            $this->load->view("cart/_order_summary");
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->
