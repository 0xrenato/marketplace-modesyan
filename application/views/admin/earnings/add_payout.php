<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('add_payout'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>payout-requests" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?php echo trans('payout_requests'); ?>
                    </a>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('earnings_controller/add_payout_post', ['class' => 'validate_price']); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?php echo trans("user"); ?></label>
                    <select name="user_id" class="form-control" required>
                        <option value="" selected><?php echo trans("select"); ?></option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user->id; ?>"><?php echo $user->id; ?>&nbsp;&nbsp;--&nbsp;<?php echo $user->username; ?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php echo price_formatted($user->balance, $this->payment_settings->default_currency); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo trans("withdraw_method"); ?></label>
                    <select name="payout_method" class="form-control custom-select" required>
                        <option value="" selected><?php echo trans("select"); ?></option>
                        <option value="paypal">PayPal</option>
                        <option value="iban"><?php echo trans("iban"); ?></option>
                        <option value="swift"><?php echo trans("swift"); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo trans("withdraw_amount"); ?>&nbsp;(<?php echo $this->payment_settings->default_currency; ?>)</label>
                    <input type="text" name="amount" class="form-control form-input price-input" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("status"); ?></label>
                    <select name="status" class="form-control custom-select" required>
                        <option value="" selected><?php echo trans("select"); ?></option>
                        <option value="0"><?php echo trans("pending"); ?></option>
                        <option value="1"><?php echo trans("completed"); ?></option>
                    </select>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_payout'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
