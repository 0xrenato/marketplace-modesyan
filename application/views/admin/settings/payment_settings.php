<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $stripe_locales = ['auto' => 'Auto', 'ar' => 'Arabic', 'bg' => 'Bulgarian (Bulgaria)', 'cs' => 'Czech (Czech Republic)', 'da' => 'Danish', 'de' => 'German (Germany)', 'el' => 'Greek (Greece)',
    'en' => 'English', 'en-GB' => 'English (United Kingdom)', 'es' => 'Spanish (Spain)', 'es-419' => 'Spanish (Latin America)', 'et' => 'Estonian (Estonia)', 'fi' => 'Finnish (Finland)',
    'fr' => 'French (France)', 'fr-CA' => 'French (Canada)', 'he' => 'Hebrew (Israel)', 'id' => 'Indonesian (Indonesia)', 'it' => 'Italian (Italy)', 'ja' => 'Japanese', 'lt' => 'Lithuanian (Lithuania)',
    'lv' => 'Latvian (Latvia)', 'ms' => 'Malay (Malaysia)', 'nb' => 'Norwegian Bokmål', 'nl' => 'Dutch (Netherlands)', 'pl' => 'Polish (Poland)', 'pt' => 'Portuguese (Brazil)', 'ru' => 'Russian (Russia)',
    'sk' => 'Slovak (Slovakia)', 'sl' => 'Slovenian (Slovenia)', 'sv' => 'Swedish (Sweden)', 'zh' => 'Chinese Simplified (China)']; ?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;margin-top: 10px;"><?php echo trans('payment_settings'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <?php $paypal = get_payment_gateway('paypal');
        if (!empty($paypal)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $paypal->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="paypal">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/paypal.svg" alt="paypal" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_paypal"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_paypal_1" class="custom-control-input" <?= $paypal->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_paypal_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_paypal_2" class="custom-control-input" <?= $paypal->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_paypal_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("mode"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="environment" value="production" id="environment_paypal_1" class="custom-control-input" <?= $paypal->environment == 'production' ? 'checked' : ''; ?>>
                                    <label for="environment_paypal_1" class="custom-control-label"><?php echo trans("production"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="environment" value="sandbox" id="environment_paypal_2" class="custom-control-input" <?= $paypal->environment != 'production' ? 'checked' : ''; ?>>
                                    <label for="environment_paypal_2" class="custom-control-label"><?php echo trans("sandbox"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("client_id"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("client_id"); ?>" value="<?= $paypal->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("secret_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("secret_key"); ?>" value="<?= $paypal->secret_key; ?>">
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <option value="all" <?= $paypal->base_currency == 'all' ? 'selected' : ''; ?>><?= trans("all_active_currencies"); ?></option>
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency->code; ?>" <?= $paypal->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6 col-md-12">
        <?php $stripe = get_payment_gateway('stripe');
        if (!empty($stripe)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $stripe->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="stripe">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/stripe.svg" alt="stripe" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_stripe"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_stripe_1" class="custom-control-input" <?= $stripe->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_stripe_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_stripe_2" class="custom-control-input" <?= $stripe->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_stripe_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("publishable_key"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("publishable_key"); ?>" value="<?= $stripe->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("secret_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("secret_key"); ?>" value="<?= $stripe->secret_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("language"); ?></label>
                        <select name="locale" class="form-control" required>
                            <?php foreach ($stripe_locales as $key => $value): ?>
                                <option value="<?= $key; ?>" <?= ($key == $stripe->locale) ? 'selected' : ''; ?>><?= $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <option value="all" <?= $stripe->base_currency == 'all' ? 'selected' : ''; ?>><?= trans("all_active_currencies"); ?></option>
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency->code; ?>" <?= $stripe->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <?php $paystack = get_payment_gateway('paystack');
        if (!empty($paystack)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $paystack->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="paystack">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/paystack.svg" alt="paystack" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_paystack"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_paystack_1" class="custom-control-input" <?= $paystack->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_paystack_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_paystack_2" class="custom-control-input" <?= $paystack->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_paystack_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("public_key"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("public_key"); ?>" value="<?= $paystack->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("secret_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("secret_key"); ?>" value="<?= $paystack->secret_key; ?>">
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <option value="all" <?= $paystack->base_currency == 'all' ? 'selected' : ''; ?>><?= trans("all_active_currencies"); ?></option>
                                <?php foreach ($currencies as $currency):
                                    if ($currency->code == "NGN" || $currency->code == "USD" || $currency->code == "GHS" || $currency->code == "ZAR"):?>
                                        <option value="<?= $currency->code; ?>" <?= $paystack->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                    <?php endif;
                                endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6 col-md-12">
        <?php $flutterwave = get_payment_gateway('flutterwave');
        if (!empty($flutterwave)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $flutterwave->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="flutterwave">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/flutterwave.svg" alt="flutterwave" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_flutterwave"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_flutterwave_1" class="custom-control-input" <?= $flutterwave->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_flutterwave_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_flutterwave_2" class="custom-control-input" <?= $flutterwave->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_flutterwave_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("public_key"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("public_key"); ?>" value="<?= $flutterwave->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("secret_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("secret_key"); ?>" value="<?= $flutterwave->secret_key; ?>">
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <option value="all" <?= $flutterwave->base_currency == 'all' ? 'selected' : ''; ?>><?= trans("all_active_currencies"); ?></option>
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency->code; ?>" <?= $flutterwave->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <?php $midtrans = get_payment_gateway('midtrans');
        if (!empty($midtrans)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $midtrans->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="midtrans">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/midtrans.svg" alt="midtrans" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_midtrans"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_midtrans_1" class="custom-control-input" <?= $midtrans->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_midtrans_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_midtrans_2" class="custom-control-input" <?= $midtrans->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_midtrans_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("mode"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="environment" value="production" id="environment_midtrans_1" class="custom-control-input" <?= $midtrans->environment == 'production' ? 'checked' : ''; ?>>
                                    <label for="environment_midtrans_1" class="custom-control-label"><?php echo trans("production"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="environment" value="sandbox" id="environment_midtrans_2" class="custom-control-input" <?= $midtrans->environment != 'production' ? 'checked' : ''; ?>>
                                    <label for="environment_midtrans_2" class="custom-control-label"><?php echo trans("sandbox"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("api_key"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("api_key"); ?>" value="<?= $midtrans->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("server_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("server_key"); ?>" value="<?= $midtrans->secret_key; ?>">
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <?php foreach ($currencies as $currency):
                                    if ($currency->code == "IDR"):?>
                                        <option value="<?= $currency->code; ?>" <?= $midtrans->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                    <?php endif;
                                endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6 col-md-12">
        <?php $razorpay = get_payment_gateway('razorpay');
        if (!empty($razorpay)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $razorpay->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="razorpay">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/razorpay.svg" alt="razorpay" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_razorpay"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_razorpay_1" class="custom-control-input" <?= $razorpay->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_razorpay_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_razorpay_2" class="custom-control-input" <?= $razorpay->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_razorpay_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("api_key"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("api_key"); ?>" value="<?= $razorpay->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("secret_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("secret_key"); ?>" value="<?= $razorpay->secret_key; ?>">
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <option value="all" <?= $razorpay->base_currency == 'all' ? 'selected' : ''; ?>><?= trans("all_active_currencies"); ?></option>
                                <?php foreach ($currencies as $currency): ?>
                                    <option value="<?= $currency->code; ?>" <?= $razorpay->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="row">
    <div class="col-lg-6 col-md-12">
        <?php $iyzico = get_payment_gateway('iyzico');
        if (!empty($iyzico)):?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $iyzico->name; ?></h3>
                </div>
                <?php echo form_open('settings_controller/payment_gateway_settings_post'); ?>
                <input type="hidden" name="name_key" value="iyzico">
                <div class="box-body">
                    <img src="<?php echo base_url(); ?>assets/img/payment/iyzico.svg" alt="iyzico" class="img-payment-logo">
                    <?php if (!empty($this->session->flashdata("mes_iyzico"))):
                        $this->load->view('admin/includes/_messages');
                    endif; ?>
                    <div class="alert alert-info alert-large">
                        <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("iyzico_warning"); ?> <a href="https://dev.iyzipay.com/en/checkout-form" target="_blank" style="color: #0c5460;font-weight: bold">Iyzico Checkout Form</a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("status"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="1" id="status_iyzico_1" class="custom-control-input" <?= $iyzico->status == 1 ? 'checked' : ''; ?>>
                                    <label for="status_iyzico_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" value="0" id="status_iyzico_2" class="custom-control-input" <?= $iyzico->status != 1 ? 'checked' : ''; ?>>
                                    <label for="status_iyzico_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <label><?= trans("mode"); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="environment" value="production" id="environment_iyzico_1" class="custom-control-input" <?= $iyzico->environment == 'production' ? 'checked' : ''; ?>>
                                    <label for="environment_iyzico_1" class="custom-control-label"><?php echo trans("production"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="environment" value="sandbox" id="environment_iyzico_2" class="custom-control-input" <?= $iyzico->environment != 'production' ? 'checked' : ''; ?>>
                                    <label for="environment_iyzico_2" class="custom-control-label"><?php echo trans("sandbox"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("api_key"); ?></label>
                        <input type="text" class="form-control" name="public_key" placeholder="<?= trans("api_key"); ?>" value="<?= $iyzico->public_key; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans("secret_key"); ?></label>
                        <input type="text" class="form-control" name="secret_key" placeholder="<?= trans("secret_key"); ?>" value="<?= $iyzico->secret_key; ?>">
                    </div>
                    <?php if (!empty($currencies) && $this->payment_settings->currency_converter == 1): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("base_currency"); ?></label>
                            <select name="base_currency" class="form-control">
                                <?php foreach ($currencies as $currency):
                                    if ($currency->code == "TRY"):?>
                                        <option value="<?= $currency->code; ?>" <?= $iyzico->base_currency == $currency->code ? 'selected' : ''; ?>><?= $currency->code; ?>&nbsp;(<?= $currency->name; ?>)</option>
                                    <?php endif;
                                endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('cash_on_delivery'); ?></h3><br>
                <small><?php echo trans("cash_on_delivery_exp"); ?></small>
            </div>
            <?php echo form_open('settings_controller/cash_on_delivery_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_cash_on_delivery"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label><?= trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="cash_on_delivery_enabled" value="1" id="status_cash_on_delivery_1" class="custom-control-input" <?= $this->payment_settings->cash_on_delivery_enabled == 1 ? 'checked' : ''; ?>>
                                <label for="status_cash_on_delivery_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="cash_on_delivery_enabled" value="0" id="status_cash_on_delivery_2" class="custom-control-input" <?= $this->payment_settings->cash_on_delivery_enabled != 1 ? 'checked' : ''; ?>>
                                <label for="status_cash_on_delivery_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('bank_transfer'); ?></h3><br>
                <small><?php echo trans("bank_transfer_exp"); ?></small>
            </div>
            <?php echo form_open('settings_controller/bank_transfer_settings_post'); ?>
            <div class="box-body">
                <?php if (!empty($this->session->flashdata("mes_bank_transfer"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <label><?= trans("status"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="bank_transfer_enabled" value="1" id="bank_transfer_enabled_1" class="custom-control-input" <?= $this->payment_settings->bank_transfer_enabled == 1 ? 'checked' : ''; ?>>
                                <label for="bank_transfer_enabled_1" class="custom-control-label"><?php echo trans("enable"); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="bank_transfer_enabled" value="0" id="bank_transfer_enabled_2" class="custom-control-input" <?= $this->payment_settings->bank_transfer_enabled != 1 ? 'checked' : ''; ?>>
                                <label for="bank_transfer_enabled_2" class="custom-control-label"><?php echo trans("disable"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('bank_accounts'); ?></label>
                    <textarea class="form-control tinyMCEsmall" name="bank_transfer_accounts"><?php echo $this->payment_settings->bank_transfer_accounts; ?></textarea>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<style>
    .img-payment-logo {
        height: 28px;
        position: absolute;
        right: 15px;
        top: 15px;
    }
</style>