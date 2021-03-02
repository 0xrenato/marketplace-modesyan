<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('update_seller_balance'); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('earnings_controller/update_seller_balance_post'); ?>
            <input type="hidden" name="user_id" value="<?php echo $seller->id; ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('user_id'); ?>:&nbsp;<?php echo $seller->id; ?></label><br>
                    <label class="label-sitemap"><?php echo trans('username'); ?>:&nbsp;<?php echo $seller->username; ?></label>
                </div>
                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('number_of_total_sales'); ?></label>
                    <input type="number" class="form-control" name="number_of_sales" value="<?php echo $seller->number_of_sales; ?>" min="0" required>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('balance'); ?></label>
                    <input type="text" name="balance" class="form-control form-input price-input" value="<?php echo get_price($seller->balance, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

</div>

