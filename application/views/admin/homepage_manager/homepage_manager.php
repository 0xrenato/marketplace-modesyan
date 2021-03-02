<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;"><?= $title; ?></h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?php echo trans('featured_categories'); ?><br>
                    <small><?php echo trans('featured_categories_exp'); ?></small>
                </h3>
            </div>
            <?php echo form_open('admin_controller/homepage_manager_post'); ?>
            <input type="hidden" name="is_form" value="1">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("category"); ?></label>
                    <select id="categories" name="category_id[]" class="form-control" onchange="get_subcategories(this.value, 0,'category_select_container');" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($parent_categories as $item): ?>
                            <option value="<?php echo html_escape($item->id); ?>"><?php echo category_name($item); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="category_select_container"></div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" name="submit" value="featured_categories" class="btn btn-primary"><?php echo trans('select_category'); ?></button>
                </div>
                <hr>
                <div class="form-group">
                    <table class="table table-bordered table-striped" role="grid">
                        <tbody>
                        <?php if (!empty($featured_categories)):
                            foreach ($featured_categories as $item):
                                if (!empty($item)):
                                    $categories_tree = get_parent_categories_tree($item, false);
                                    if (!empty($categories_tree)):?>
                                        <tr>
                                            <td style="vertical-align: middle">
                                                <?php $count = 0;
                                                foreach ($categories_tree as $item_tree):
                                                    if (!empty($item_tree)):
                                                        if ($count == 0) {
                                                            echo category_name($item_tree);
                                                        } else {
                                                            echo " / " . category_name($item_tree);
                                                        }
                                                    endif;
                                                    $count++;
                                                endforeach; ?>
                                                <button type="button" class="btn btn-xs btn-default pull-right" onclick='remove_by_homepage_manager(<?php echo $item->id; ?>,"featured_categories");' style="height: 24px;"><?php echo trans("delete"); ?></button>
                                                <input type="number" class="form-control input-featured-categories-order m-r-5 pull-right" value="<?= $item->featured_order; ?>" data-category-id="<?= $item->id; ?>" min="1" max="9999999" placeholder="<?= trans("order"); ?>" style="width: 80px; display: inline-block; height: 24px;">
                                            </td>
                                        </tr>
                                    <?php endif;
                                endif;
                            endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?php echo trans("products_by_category"); ?><br>
                    <small><?php echo trans("products_by_category_exp"); ?></small>
                </h3>
            </div>
            <?php echo form_open('admin_controller/homepage_manager_post'); ?>
            <input type="hidden" name="is_form" value="1">
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("category"); ?></label>
                    <select id="categories" name="category_id[]" class="form-control" onchange="get_subcategories(this.value, 0,'category_select_container_1');" required>
                        <option value=""><?php echo trans('select_category'); ?></option>
                        <?php foreach ($parent_categories as $item): ?>
                            <option value="<?php echo html_escape($item->id); ?>"><?php echo category_name($item); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="category_select_container_1"></div>
                </div>
                <div class="form-group">
                    <div class="col-custom-option">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="show_subcategory_products" id="checkbox_show_subcategory_products" value="1" class="custom-control-input">
                            <label for="checkbox_show_subcategory_products" class="custom-control-label font-weight-normal"><?php echo trans("show_subcategory_products"); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" name="submit" value="products_by_category" class="btn btn-primary"><?php echo trans('select_category'); ?></button>
                </div>
                <hr>
                <div class="form-group">
                    <table class="table table-bordered table-striped" role="grid">
                        <tbody>
                        <?php if (!empty($index_categories)):
                            foreach ($index_categories as $item):
                                if (!empty($item)):
                                    $categories_tree = get_parent_categories_tree($item, false);
                                    if (!empty($categories_tree)):?>
                                        <tr>
                                            <td>
                                                <?php $count = 0;
                                                foreach ($categories_tree as $item_tree):
                                                    if (!empty($item_tree)):
                                                        if ($count == 0) {
                                                            echo category_name($item_tree);
                                                        } else {
                                                            echo " / " . category_name($item_tree);
                                                        }
                                                    endif;
                                                    $count++;
                                                endforeach; ?>

                                                <button type="button" class="btn btn-xs btn-default pull-right" onclick='remove_by_homepage_manager(<?php echo $item->id; ?>,"products_by_category");' style="height: 24px;"><?php echo trans("delete"); ?></button>
                                                <input type="number" class="form-control input-index-categories-order m-r-5 pull-right" value="<?= $item->homepage_order; ?>" data-category-id="<?= $item->id; ?>" min="1" max="9999999" placeholder="<?= trans("order"); ?>" style="width: 80px; display: inline-block; height: 24px;">
                                                <?php if ($item->show_subcategory_products == 1): ?>
                                                    <a data-toggle="tooltip" data-placement="top" title="<?php echo trans("show_subcategory_products"); ?>" class="m-r-5 pull-right" style="line-height: 24px;"><i class="fa fa-th"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif;
                                endif;
                            endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div id="section_banners" class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">
                        <?php echo trans('homepage_banners'); ?><br>
                        <small><?php echo trans('homepage_banners_exp'); ?></small>
                    </h3>
                </div>
                <div class="right">
                    <button type="button" class="btn btn-success btn-add-new" data-toggle="modal" data-target="#addBannerModal"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?= trans("add_banner"); ?></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table data-page-length="8" class="table table-bordered table-striped data_table table-no-sort" role="grid">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans("id"); ?></th>
                                    <th><?= trans("banner"); ?></th>
                                    <th><?= trans("url"); ?></th>
                                    <th><?= trans("order"); ?></th>
                                    <th><?= trans("banner_width"); ?></th>
                                    <th><?= trans("location"); ?></th>
                                    <th class="th-options"><?php echo trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($index_banners)):
                                    foreach ($index_banners as $item):
                                        if (!empty($item)): ?>
                                            <tr>
                                                <td><?= $item->id; ?></td>
                                                <td>
                                                    <img src="<?= base_url() . $item->banner_image_path; ?>" style="max-width: 160px; max-height: 160px;">
                                                </td>
                                                <td><?= $item->banner_url; ?></td>
                                                <td><?= $item->banner_order; ?></td>
                                                <td><?= $item->banner_width; ?>%</td>
                                                <td><?= trans($item->banner_location); ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-option">
                                                        <a href="<?= admin_url(); ?>edit-banner/<?= $item->id; ?>" class="btn btn-sm btn-default btn-edit"><?= trans("edit"); ?></a>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="delete_item('admin_controller/delete_index_banner_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif;
                                    endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                            <?php if (empty($index_banners)): ?>
                                <p class="text-center">
                                    <?php echo trans("no_records_found"); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="product_settings" class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("settings"); ?></h3>
            </div>
            <?php echo form_open('admin_controller/homepage_manager_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_settings'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("featured_categories"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="featured_categories" value="1" id="featured_categories_1" class="square-purple" <?php echo ($this->general_settings->featured_categories == 1) ? 'checked' : ''; ?>>
                            <label for="featured_categories_1" class="option-label"><?php echo trans("show"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="featured_categories" value="0" id="featured_categories_2" class="square-purple" <?php echo ($this->general_settings->featured_categories != 1) ? 'checked' : ''; ?>>
                            <label for="featured_categories_2" class="option-label"><?php echo trans("hide"); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("featured_products"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="index_promoted_products" value="1" id="featured_products_1" class="square-purple" <?php echo ($this->general_settings->index_promoted_products == 1) ? 'checked' : ''; ?>>
                            <label for="featured_products_1" class="option-label"><?php echo trans("show"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="index_promoted_products" value="0" id="featured_products_2" class="square-purple" <?php echo ($this->general_settings->index_promoted_products != 1) ? 'checked' : ''; ?>>
                            <label for="featured_products_2" class="option-label"><?php echo trans("hide"); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans("latest_products"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="index_latest_products" value="1" id="index_latest_products_1" class="square-purple" <?php echo ($this->general_settings->index_latest_products == 1) ? 'checked' : ''; ?>>
                            <label for="index_latest_products_1" class="option-label"><?php echo trans("show"); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="index_latest_products" value="0" id="index_latest_products_2" class="square-purple" <?php echo ($this->general_settings->index_latest_products != 1) ? 'checked' : ''; ?>>
                            <label for="index_latest_products_2" class="option-label"><?php echo trans("hide"); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('blog_slider'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="index_blog_slider" value="1" id="blog_slider_1" class="square-purple" <?php echo ($this->general_settings->index_blog_slider == 1) ? 'checked' : ''; ?>>
                            <label for="blog_slider_1" class="option-label"><?php echo trans('show'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="radio" name="index_blog_slider" value="0" id="blog_slider_2" class="square-purple" <?php echo ($this->general_settings->index_blog_slider != 1) ? 'checked' : ''; ?>>
                            <label for="blog_slider_2" class="option-label"><?php echo trans('hide'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label class="control-label"><?php echo trans("number_featured_products"); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="number" class="form-control" name="index_promoted_products_count" value="<?php echo html_escape($this->general_settings->index_promoted_products_count); ?>" min="1" required style="max-width: 600px;">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label class="control-label"><?php echo trans('number_latest_products'); ?></label>
                        </div>
                        <div class="col-md-6 col-xs-12 col-option">
                            <input type="number" class="form-control" name="index_latest_products_count" value="<?php echo html_escape($this->general_settings->index_latest_products_count); ?>" min="1" required style="max-width: 600px;">
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

<div id="addBannerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open_multipart('admin_controller/add_index_banner_post'); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans("add_banner"); ?></h4>
            </div>
            <div class="modal-body">
                <?php if (!empty($this->session->flashdata('msg_banner'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="text" name="banner_url" class="form-control" placeholder="<?php echo trans("banner"); ?>&nbsp;<?= trans("url"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="banner_order" min="1" max="9999999" class="form-control" placeholder="<?= trans("order"); ?>" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" name="banner_width" min="1" max="100" step="0.01" class="form-control" placeholder="<?= trans("banner_width"); ?>&nbsp;(E.g: 50)" required>
                                <span class="input-group-addon"><strong>%</strong></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label><?php echo trans("location"); ?>&nbsp;<small>(<?= trans("banner_location_exp"); ?>)</small></label>
                                </div>
                                <div class="col-sm-12 col-option">
                                    <input type="radio" name="banner_location" value="featured_categories" id="location_1" class="square-purple" checked>
                                    <label for="location_1" class="option-label"><?php echo trans("featured_categories"); ?></label>
                                </div>
                                <div class="col-sm-12 col-option">
                                    <input type="radio" name="banner_location" value="special_offers" id="location_2" class="square-purple">
                                    <label for="location_2" class="option-label"><?php echo trans("special_offers"); ?></label>
                                </div>
                                <div class="col-sm-12 col-option">
                                    <input type="radio" name="banner_location" value="featured_products" id="location_3" class="square-purple">
                                    <label for="location_3" class="option-label"><?php echo trans("featured_products"); ?></label>
                                </div>
                                <div class="col-sm-12 col-option">
                                    <input type="radio" name="banner_location" value="new_arrivals" id="location_4" class="square-purple">
                                    <label for="location_4" class="option-label"><?php echo trans("new_arrivals"); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("banner"); ?></label>
                            <div class="display-block">
                                <a class='btn btn-default btn-sm btn-file-upload'>
                                    <i class="fa fa-image text-muted"></i>&nbsp;&nbsp;<?php echo trans("select_image"); ?>
                                    <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));" required>
                                </a>
                                <br>
                                <span class='label label-default label-file-upload' id="upload-file-info"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?= trans("add_banner"); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    var div_select_id_global = "";

    function get_subcategories(category_id, data_select_id, div_select_id = null) {
        if (div_select_id != null) {
            div_select_id_global = div_select_id;
        }
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('.subcategory-select').each(function () {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<select class="form-control subcategory-select" data-select-id="' + new_data_select_id + '" name="category_id[]" onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
                '<option value=""><?php echo trans('none'); ?></option>';
            for (i = 0; i < subcategories.length; i++) {
                select_tag += '<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>';
            }
            select_tag += '</select>';
            $('#' + div_select_id_global).append(select_tag);
        }
    }

    function get_subcategories_array(category_id) {
        var categories_array = <?php echo get_categories_json($this->selected_lang->id); ?>;
        var subcategories_array = [];
        for (i = 0; i < categories_array.length; i++) {
            if (categories_array[i].parent_id == category_id) {
                subcategories_array.push(categories_array[i]);
            }
        }
        return subcategories_array;
    }
</script>
<style>
    .dataTables_length, .dataTables_filter, .dataTables_empty, .dataTables_info, .pagination .disabled {
        display: none !important;
    }
</style>