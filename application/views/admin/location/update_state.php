<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_state"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/update_state_post'); ?>
            <input type="hidden" name="id" value="<?php echo $state->id; ?>">
            <input type="hidden" name="redirect_url" value="<?php echo $this->agent->referrer(); ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?php echo trans('country'); ?></label>
                    <select name="country_id" class="form-control" required>
                        <option value=""><?php echo trans("select"); ?></option>
                        <?php
                        foreach ($countries as $item): ?>
                            <option value="<?php echo $item->id; ?>" <?php echo ($state->country_id == $item->id) ? 'selected' : ''; ?>>
                                <?php echo html_escape($item->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans("name"); ?></label>
                    <input type="text" class="form-control" name="name" value="<?php echo $state->name; ?>" placeholder="<?php echo trans("name"); ?>" maxlength="200" required>
                </div>

            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('update_state'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
