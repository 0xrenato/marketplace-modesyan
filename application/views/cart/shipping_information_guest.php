<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
                                <div class="tab-checkout tab-checkout-open m-t-0">
                                    <h2 class="title">1.&nbsp;&nbsp;<?php echo trans("shipping_information"); ?></h2>
                                    <?php echo form_open("shipping-post", ['id' => 'form-guest-shipping', 'class' => 'validate-form']);
                                    $mds_cart_shipping = get_sess_data('mds_cart_shipping');
                                    $show_billing_form = 0;
                                    if (empty($mds_cart_shipping)) {
                                        $show_billing_form = 0;
                                    } else {
                                        if (empty($mds_cart_shipping->use_same_address_for_billing)) {
                                            $show_billing_form = 1;
                                        }
                                    }
                                    $shipping_address = array();
                                    $billing_address = array();
                                    if (!empty($mds_cart_shipping)):
                                        if (!empty($mds_cart_shipping->guest_shipping_address)):
                                            $shipping_address = $mds_cart_shipping->guest_shipping_address;
                                        endif;
                                        if (!empty($mds_cart_shipping->guest_billing_address)):
                                            $billing_address = $mds_cart_shipping->guest_billing_address;
                                        endif;
                                    endif; ?>
                                    <div class="row">
                                        <div class="col-12 cart-form-shipping-address">
                                            <p class="text-shipping-address"><?= trans("shipping_address") ?></p>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("first_name"); ?></label>
                                                        <input type="text" name="shipping_first_name" class="form-control form-input" value="<?= !empty($shipping_address['first_name']) ? html_escape($shipping_address['first_name']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("last_name"); ?></label>
                                                        <input type="text" name="shipping_last_name" class="form-control form-input" value="<?= !empty($shipping_address['last_name']) ? html_escape($shipping_address['last_name']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("email"); ?></label>
                                                        <input type="email" name="shipping_email" class="form-control form-input" value="<?= !empty($shipping_address['email']) ? html_escape($shipping_address['email']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("phone_number"); ?></label>
                                                        <input type="text" name="shipping_phone_number" class="form-control form-input" value="<?= !empty($shipping_address['phone_number']) ? html_escape($shipping_address['phone_number']) : ''; ?>" maxlength="100" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?></label>
                                                <input type="text" name="shipping_address" class="form-control form-input" value="<?= !empty($shipping_address['address']) ? html_escape($shipping_address['address']) : ''; ?>" maxlength="250" required>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label class="control-label"><?php echo trans("country"); ?></label>
                                                        <select id="select_countries_guest_address" name="shipping_country_id" class="select2 select2-req form-control" data-placeholder="<?= trans("country"); ?>" onchange="get_states(this.value,false,'guest_address'); $('#cart_shipping_methods_container').empty();" required>
                                                            <option></option>
                                                            <?php foreach ($this->countries as $item): ?>
                                                                <option value="<?= $item->id; ?>" <?= !empty($shipping_address['country_id']) && $shipping_address['country_id'] == $item->id ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div id="get_states_container_guest_address" class="col-12 col-md-6">
                                                        <label class="control-label"><?php echo trans("state"); ?></label>
                                                        <select id="select_states_guest_address" name="shipping_state_id" class="select2 select2-req form-control" data-placeholder="<?= trans("state"); ?>" onchange="get_shipping_methods_by_location(this.value);" required>
                                                            <?php if (!empty($shipping_address['country_id'])):
                                                                $states = get_states_by_country($shipping_address['country_id']);
                                                            endif;
                                                            if (!empty($states)):
                                                                foreach ($states as $item): ?>
                                                                    <option value="<?= $item->id; ?>" <?= !empty($shipping_address['state_id']) && $shipping_address['state_id'] == $item->id ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
                                                                <?php endforeach;
                                                            endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label class="control-label"><?= trans("city"); ?></label>
                                                        <input type="text" name="shipping_city" class="form-control form-input" value="<?= !empty($shipping_address['city']) ? html_escape($shipping_address['city']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label class="control-label"><?= trans("zip_code"); ?></label>
                                                        <input type="text" name="shipping_zip_code" class="form-control form-input" value="<?= !empty($shipping_address['zip_code']) ? html_escape($shipping_address['zip_code']) : ''; ?>" maxlength="90" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 cart-form-billing-address" <?= $show_billing_form == 1 ? 'style="display: block;"' : ''; ?>>
                                            <p class="text-shipping-address"><?= trans("billing_address") ?></p>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("first_name"); ?></label>
                                                        <input type="text" name="billing_first_name" class="form-control form-input" value="<?= !empty($billing_address['first_name']) ? html_escape($billing_address['first_name']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("last_name"); ?></label>
                                                        <input type="text" name="billing_last_name" class="form-control form-input" value="<?= !empty($billing_address['last_name']) ? html_escape($billing_address['last_name']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("email"); ?></label>
                                                        <input type="email" name="billing_email" class="form-control form-input" value="<?= !empty($billing_address['email']) ? html_escape($billing_address['email']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("phone_number"); ?></label>
                                                        <input type="text" name="billing_phone_number" class="form-control form-input" value="<?= !empty($billing_address['phone_number']) ? html_escape($billing_address['phone_number']) : ''; ?>" maxlength="100" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?></label>
                                                <input type="text" name="billing_address" class="form-control form-input" value="<?= !empty($billing_address['address']) ? html_escape($billing_address['address']) : ''; ?>" maxlength="250" required>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label class="control-label"><?php echo trans("country"); ?></label>
                                                        <select id="select_countries_guest_billing" name="billing_country_id" class="select2 form-control <?= $show_billing_form == 1 ? 'select2-req' : ''; ?>" data-placeholder="<?= trans("country"); ?>" onchange="get_states(this.value,false,'guest_billing');" required>
                                                            <option></option>
                                                            <?php foreach ($this->countries as $item): ?>
                                                                <option value="<?= $item->id; ?>" <?= !empty($billing_address['country_id']) && $billing_address['country_id'] == $item->id ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div id="get_states_container_guest_billing" class="col-12 col-md-6">
                                                        <label class="control-label"><?php echo trans("state"); ?></label>
                                                        <select id="select_states_guest_billing" name="billing_state_id" class="select2 form-control <?= $show_billing_form == 1 ? 'select2-req' : ''; ?>" data-placeholder="<?= trans("state"); ?>" required>
                                                            <?php if (!empty($billing_address['country_id'])):
                                                                $states = get_states_by_country($billing_address['country_id']);
                                                            endif;
                                                            if (!empty($states)):
                                                                foreach ($states as $item): ?>
                                                                    <option value="<?= $item->id; ?>" <?= !empty($billing_address['state_id']) && $billing_address['state_id'] == $item->id ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
                                                                <?php endforeach;
                                                            endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label class="control-label"><?= trans("city"); ?></label>
                                                        <input type="text" name="billing_city" class="form-control form-input" value="<?= !empty($billing_address['city']) ? html_escape($billing_address['city']) : ''; ?>" maxlength="250" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label class="control-label"><?= trans("zip_code"); ?></label>
                                                        <input type="text" name="billing_zip_code" class="form-control form-input" value="<?= !empty($billing_address['zip_code']) ? html_escape($billing_address['zip_code']) : ''; ?>" maxlength="90" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="use_same_address_for_billing" value="1" id="use_same_address_for_billing" <?= $show_billing_form == 0 ? 'checked' : ''; ?>>
                                                    <label for="use_same_address_for_billing" class="custom-control-label"><?php echo trans("use_same_address_for_billing"); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div id="cart_shipping_methods_container" class="shipping-methods-container">
                                                <?php if (!empty($shipping_address) && !empty($shipping_address['state_id'])):
                                                    $this->load->view("cart/_shipping_methods"); endif; ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="cart-shipping-loader">
                                                        <div class="spinner">
                                                            <div class="bounce1"></div>
                                                            <div class="bounce2"></div>
                                                            <div class="bounce3"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <?php echo form_close(); ?>
                                </div>

                                <div class="tab-checkout tab-checkout-closed-bordered">
                                    <h2 class="title">2.&nbsp;&nbsp;<?php echo trans("payment_method"); ?></h2>
                                </div>

                                <div class="tab-checkout tab-checkout-closed-bordered border-top-0">
                                    <h2 class="title">3.&nbsp;&nbsp;<?php echo trans("payment"); ?></h2>
                                </div>
                            </div>
                        </div>

                        <?php if ($mds_payment_type == 'promote'):
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