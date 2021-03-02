<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/update_currency_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <input type="hidden" name="id" value="<?php echo $currency->id; ?>">

                <div class="form-group">
                    <label><?php echo trans("currency_name"); ?></label>
                    <input type="text" class="form-control" name="name" value="<?php echo $currency->name; ?>" placeholder="Ex: US Dollar" maxlength="200" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("currency_code"); ?></label>
                    <input type="text" class="form-control" name="code" value="<?php echo $currency->code; ?>" placeholder="Ex: USD" maxlength="99" required>
                </div>

                <div class="form-group">
                    <label><?php echo trans("currency_symbol"); ?></label>
                    <input type="text" class="form-control" name="symbol" value="<?php echo $currency->symbol; ?>" placeholder="Ex: $" maxlength="99" required>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans('currency_format'); ?> (Thousands Seperator)</label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="currency_format" value="us" id="currency_format_1" class="square-purple" <?= $currency->currency_format == 'us' ? 'checked' : ''; ?>>
                            <label for="currency_format_1" class="option-label">1<strong>,</strong>234<strong>,</strong>567<strong>.</strong>89</label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="currency_format" value="european" id="currency_format_2" class="square-purple" <?= $currency->currency_format == 'european' ? 'checked' : ''; ?>>
                            <label for="currency_format_2" class="option-label">1<strong>.</strong>234<strong>.</strong>567<strong>,</strong>89</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans('currency_symbol_format'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="symbol_direction" value="left" id="symbol_direction_1" class="square-purple" <?= $currency->symbol_direction == 'left' ? 'checked' : ''; ?>>
                            <label for="symbol_direction_1" class="option-label">$100 (<?php echo trans("left"); ?>)</label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="symbol_direction" value="right" id="symbol_direction_2" class="square-purple" <?= $currency->symbol_direction == 'right' ? 'checked' : ''; ?>>
                            <label for="symbol_direction_2" class="option-label">100$ (<?php echo trans("right"); ?>)</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans('add_space_between_money_currency'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="space_money_symbol" value="1" id="space_money_symbol_1" class="square-purple" <?= $currency->space_money_symbol == 1 ? 'checked' : ''; ?>>
                            <label for="space_money_symbol_1" class="option-label"><?php echo trans("yes"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="space_money_symbol" value="0" id="space_money_symbol_2" class="square-purple" <?= $currency->space_money_symbol != 1 ? 'checked' : ''; ?>>
                            <label for="space_money_symbol_2" class="option-label"><?php echo trans("no"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="1" id="status_1" class="square-purple" <?= $currency->status == 1 ? 'checked' : ''; ?>>
                            <label for="status_1" class="option-label"><?php echo trans("active"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="0" id="status_2" class="square-purple" <?= $currency->status != 1 ? 'checked' : ''; ?>>
                            <label for="status_2" class="option-label"><?php echo trans("inactive"); ?></label>
                        </div>
                    </div>
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
