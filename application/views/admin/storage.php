<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('storage'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/storage_post'); ?>
            <div class="box-body">

                <?php $mes = $this->session->flashdata('mes_s3');
                if (!isset($mes)) {
                    $this->load->view('admin/includes/_messages');
                } ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans('storage'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="storage" value="local" id="storage_1"
                                   class="square-purple" <?php echo ($this->storage_settings->storage == "local") ? 'checked' : ''; ?>>
                            <label for="storage_1" class="option-label"><?php echo trans('local_storage'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="storage" value="aws_s3" id="storage_2"
                                   class="square-purple" <?php echo ($this->storage_settings->storage == "aws_s3") ? 'checked' : ''; ?>>
                            <label for="storage_2" class="option-label"><?php echo trans('aws_storage'); ?></label>
                        </div>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('aws_storage'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/aws_s3_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php $mes = $this->session->flashdata('mes_s3');
                if (isset($mes)) {
                    $this->load->view('admin/includes/_messages');
                } ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('aws_key'); ?></label>
                    <input type="text" class="form-control" name="aws_key" placeholder="<?php echo trans('aws_key'); ?>"
                           value="<?php echo $this->storage_settings->aws_key; ?>" required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('aws_secret'); ?></label>
                    <input type="text" class="form-control" name="aws_secret" placeholder="<?php echo trans('aws_secret'); ?>"
                           value="<?php echo $this->storage_settings->aws_secret; ?>" required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('bucket_name'); ?></label>
                    <input type="text" class="form-control" name="aws_bucket" placeholder="<?php echo trans('bucket_name'); ?>"
                           value="<?php echo $this->storage_settings->aws_bucket; ?>" required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('region'); ?></label>
                    <input type="text" class="form-control" name="aws_region" placeholder="<?php echo trans('region'); ?>"
                           value="<?php echo $this->storage_settings->aws_region; ?>" required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('aws_base_url'); ?></label>
                    <input type="text" class="form-control" name="aws_base_url" placeholder="<?php echo trans('aws_base_url'); ?>"
                           value="<?php echo $this->storage_settings->aws_base_url; ?>" required>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>