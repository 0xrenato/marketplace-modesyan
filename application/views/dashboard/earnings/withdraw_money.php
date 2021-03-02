<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= html_escape($title); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
                <div class="row">
                    <div class="col-sm-12 col-md-7">
                        <div class="withdraw-money-container">
                            <?php echo form_open('withdraw-money-post', ['id' => 'form_validate_payout_1', 'class' => 'validate_price',]); ?>
                            <div class="form-group">
                                <label><?php echo trans("withdraw_amount"); ?></label>
                                <?php
                                $min_value = 0;
                                if ($this->payment_settings->payout_paypal_enabled) {
                                    $min_value = $this->payment_settings->min_payout_paypal;
                                } elseif ($this->payment_settings->payout_iban_enabled) {
                                    $min_value = $this->payment_settings->min_payout_iban;
                                } elseif ($this->payment_settings->payout_swift_enabled) {
                                    $min_value = $this->payment_settings->min_payout_swift;
                                } ?>

                                <div class="input-group">
                                    <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                    <input type="hidden" name="currency" value="<?= $this->default_currency->code; ?>">
                                    <input type="text" name="amount" id="product_price_input" aria-describedby="basic-addon2" class="form-control form-input price-input validate-price-input" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo trans("withdraw_method"); ?></label>
                                <select name="payout_method" class="form-control custom-select" onchange="update_payout_input(this.value);" required>
                                    <?php if ($this->payment_settings->payout_paypal_enabled): ?>
                                        <option value="paypal">PayPal</option>
                                    <?php endif; ?>
                                    <?php if ($this->payment_settings->payout_iban_enabled): ?>
                                        <option value="iban"><?php echo trans("iban"); ?></option>
                                    <?php endif; ?>
                                    <?php if ($this->payment_settings->payout_swift_enabled): ?>
                                        <option value="swift"><?php echo trans("swift"); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success"><?php echo trans("submit"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="minimum-payout-container">
                            <h2 class="title"><?php echo trans("min_poyout_amounts"); ?></h2>
                            <?php if ($this->payment_settings->payout_paypal_enabled): ?>
                                <p><b>PayPal</b>:<strong><?php echo price_formatted($this->payment_settings->min_payout_paypal, $this->payment_settings->default_currency) ?></strong></p>
                            <?php endif; ?>
                            <?php if ($this->payment_settings->payout_iban_enabled): ?>
                                <p><b><?php echo trans("iban"); ?></b>:<strong><?php echo price_formatted($this->payment_settings->min_payout_iban, $this->payment_settings->default_currency) ?></strong></p>
                            <?php endif; ?>
                            <?php if ($this->payment_settings->payout_swift_enabled): ?>
                                <p><b><?php echo trans("swift"); ?></b>:<strong><?php echo price_formatted($this->payment_settings->min_payout_swift, $this->payment_settings->default_currency) ?></strong></p>
                            <?php endif; ?>
                            <hr>
                            <?php if ($this->auth_check): ?>
                                <p><b><?php echo trans("your_balance"); ?>:</b><strong><?php echo price_formatted($this->auth_user->balance, $this->payment_settings->default_currency) ?></strong></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
