<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-7">
        <div class="box box-primary">
			<div class="box-header with-border">
				<div class="left">
					<h3 class="box-title"><?php echo trans('add_custom_field'); ?></h3>
				</div>
				<div class="right">
					<a href="<?php echo admin_url(); ?>custom-fields" class="btn btn-success btn-add-new">
						<i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?php echo trans('custom_fields'); ?>
					</a>
				</div>
			</div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('category_controller/add_custom_field_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?php foreach ($this->languages as $language): ?>
                            <div class="form-group">
                                <label><?php echo trans("field_name"); ?> (<?php echo $language->name; ?>)</label>
                                <input type="text" class="form-control" name="name_lang_<?php echo $language->id; ?>" placeholder="<?php echo trans("field_name"); ?>" maxlength="255" required>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label><?php echo trans('row_width'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="row_width" value="half" id="row_width_1" class="square-purple" checked>
                                    <label for="row_width_1" class="option-label"><?php echo trans('half_width'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="row_width" value="full" id="row_width_2" class="square-purple">
                                    <label for="row_width_2" class="option-label"><?php echo trans('full_width'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <label class="control-label"><?php echo trans('required'); ?></label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="is_required" value="1" class="square-purple">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <label><?php echo trans('status'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="status" value="1" id="status_1" class="square-purple" checked>
                                    <label for="status_1" class="option-label"><?php echo trans('active'); ?></label>
                                </div>
                                <div class="col-sm-3 col-xs-12 col-option">
                                    <input type="radio" name="status" value="0" id="status_2" class="square-purple">
                                    <label for="status_2" class="option-label"><?php echo trans('inactive'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('order'); ?></label>
                            <input type="number" class="form-control" name="field_order" placeholder="<?php echo trans('order'); ?>" min="1" max="99999" value="1" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('type'); ?></label>
                            <select class="form-control" name="field_type">
                                <option value="text"><?php echo trans('text'); ?></option>
                                <option value="textarea"><?php echo trans('textarea'); ?></option>
                                <option value="number"><?php echo trans('number'); ?></option>
                                <option value="checkbox"><?php echo trans('checkbox'); ?></option>
                                <option value="radio_button"><?php echo trans('radio_button'); ?></option>
                                <option value="dropdown"><?php echo trans('dropdown'); ?></option>
                                <option value="date"><?php echo trans('date'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_and_continue'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
