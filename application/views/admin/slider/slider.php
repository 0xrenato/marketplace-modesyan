<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php $animation_array = ["none", "bounce", "flash", "pulse", "rubberBand", "shake", "swing", "tada", "wobble", "jello", "heartBeat", "bounceIn", "bounceInDown", "bounceInLeft",
    "bounceInRight", "bounceInUp", "fadeIn", "fadeInDown", "fadeInDownBig", "fadeInLeft", "fadeInLeftBig", "fadeInRight", "fadeInRightBig", "fadeInUp", "fadeInUpBig", "flip",
    "flipInX", "flipInY", "lightSpeedIn", "rotateIn", "rotateInDownLeft", "rotateInDownRight", "rotateInUpLeft", "rotateInUpRight", "slideInUp", "slideInDown", "slideInLeft",
    "slideInRight", "zoomIn", "zoomInDown", "zoomInLeft", "zoomInRight", "zoomInUp", "hinge", "jackInTheBox", "rollIn"]; ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_slider_item'); ?></h3>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/add_slider_item_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (empty($this->session->flashdata("msg_settings"))):
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($this->languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($this->selected_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('description'); ?></label>
                    <textarea name="description" class="form-control" placeholder="<?php echo trans('description'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo old('description'); ?></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('link'); ?></label>
                    <input type="text" class="form-control" name="link" placeholder="<?php echo trans('link'); ?>"
                           value="<?php echo old('link'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="row row-form">
                    <div class="col-sm-12 col-md-6 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('order'); ?></label>
                            <input type="number" class="form-control" name="item_order" placeholder="<?php echo trans('order'); ?>"
                                   value="<?php echo old('item_order'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('button_text'); ?></label>
                            <input type="text" class="form-control" name="button_text" placeholder="<?php echo trans('button_text'); ?>"
                                   value="<?php echo old('button_text'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                    </div>
                </div>

                <div class="row row-form">
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('text_color'); ?></label>
                            <input type="color" class="form-control" name="text_color" value="#ffffff">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('button_color'); ?></label>
                            <input type="color" class="form-control" name="button_color" value="#222222">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('button_text_color'); ?></label>
                            <input type="color" class="form-control" name="button_text_color" value="#ffffff">
                        </div>
                    </div>
                </div>

                <div class="row row-form">
                    <div class="col-sm-12" style="padding-left: 7.5px;">
                        <label><?php echo trans("animations"); ?></label>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label><?php echo trans("title"); ?></label>
                            <select name="animation_title" class="form-control">
                                <?php foreach ($animation_array as $animation): ?>
                                    <option value="<?php echo $animation; ?>" <?php echo ($animation == "fadeInUp") ? 'selected' : ''; ?>><?php echo $animation; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label><?php echo trans("description"); ?></label>
                            <select name="animation_description" class="form-control">
                                <?php foreach ($animation_array as $animation): ?>
                                    <option value="<?php echo $animation; ?>" <?php echo ($animation == "fadeInUp") ? 'selected' : ''; ?>><?php echo $animation; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-form">
                        <div class="form-group">
                            <label><?php echo trans("button"); ?></label>
                            <select name="animation_button" class="form-control">
                                <?php foreach ($animation_array as $animation): ?>
                                    <option value="<?php echo $animation; ?>" <?php echo ($animation == "fadeInUp") ? 'selected' : ''; ?>><?php echo $animation; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?> (1920x600)</label>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" required onchange="show_preview_image(this);">
                        </a>
                    </div>
                    <img src="<?php echo IMG_BASE64_1x1; ?>" id="img_preview_file" class="img-file-upload-preview">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?>&nbsp;(for mobile) (768x500)</label>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file_mobile" size="40" accept=".png, .jpg, .jpeg, .gif" required onchange="show_preview_image(this);">
                        </a>
                    </div>
                    <img src="<?php echo IMG_BASE64_1x1; ?>" id="img_preview_file_mobile" class="img-file-upload-preview">
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_slider_item'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('slider_items'); ?></h3>
            </div><!-- /.box-header -->

            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="cs_datatable_lang" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('image'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('order'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($slider_items as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td>
                                            <img src="<?php echo base_url() . $item->image; ?>" alt="" style="width: 200px;"/>
                                        </td>
                                        <td>
                                            <?php
                                            $language = get_language($item->lang_id);
                                            if (!empty($language)) {
                                                echo $language->name;
                                            } ?>
                                        </td>
                                        <td><?php echo $item->item_order; ?></td>

                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-slider-item/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_slider_item_post','<?php echo $item->id; ?>','<?php echo trans("confirm_slider_item"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('slider_settings'); ?></h3>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/update_slider_settings_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_settings"))):
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="slider_status" value="1" id="slider_status_1" class="square-purple" <?php echo ($this->general_settings->slider_status == 1) ? 'checked' : ''; ?>>
                            <label for="slider_status_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="slider_status" value="0" id="slider_status_2" class="square-purple" <?php echo ($this->general_settings->slider_status != 1) ? 'checked' : ''; ?>>
                            <label for="slider_status_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('type'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="slider_type" value="full_width" id="slider_type_1" class="square-purple" <?php echo ($this->general_settings->slider_type == "full_width") ? 'checked' : ''; ?>>
                            <label for="slider_type_1" class="option-label"><?php echo trans('full_width'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="slider_type" value="boxed" id="slider_type_2" class="square-purple" <?php echo ($this->general_settings->slider_type != "full_width") ? 'checked' : ''; ?>>
                            <label for="slider_type_2" class="option-label"><?php echo trans('boxed'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('effect'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="slider_effect" value="fade" id="slider_effect_1" class="square-purple" <?php echo ($this->general_settings->slider_effect == "fade") ? 'checked' : ''; ?>>
                            <label for="slider_effect_1" class="option-label">Fade</label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="slider_effect" value="slide" id="slider_effect_2" class="square-purple" <?php echo ($this->general_settings->slider_effect != "fade") ? 'checked' : ''; ?>>
                            <label for="slider_effect_2" class="option-label">Slide</label>
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
