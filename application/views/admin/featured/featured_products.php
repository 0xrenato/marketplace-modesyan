<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?php $this->load->view('admin/product/_filter_products'); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('product'); ?></th>
                            <th><?php echo trans('sku'); ?></th>
                            <th><?php echo trans('product_type'); ?></th>
                            <th><?php echo trans('category'); ?></th>
                            <th><?php echo trans('purchased_plan'); ?></th>
                            <th><?php echo trans('remaining_days'); ?></th>
                            <th><?php echo trans('user'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($products as $item): ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td class="td-product">
                                    <?php if ($item->is_promoted == 1): ?>
                                        <label class="label label-success"><?php echo trans("featured"); ?></label>
                                    <?php endif; ?>
                                    <div class="img-table">
                                        <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                        </a>
                                    </div>
                                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                        <?php echo get_product_title($item); ?>
                                    </a>
                                </td>
                                <td><?php echo $item->sku; ?></td>
                                <td><?php echo trans($item->product_type); ?></td>
                                <td>
                                    <?php $category = $this->category_model->get_category($item->category_id);
                                    if (!empty($category)) {
                                        echo html_escape($category->name);
                                    } ?>
                                </td>
                                <td>
                                    <?php if ($item->is_promoted == 1): ?>
                                        <?php echo $item->promote_plan; ?>
                                    <?php endif; ?>
                                </td>
                                <td style="min-width: 120px;">
                                    <?php if ($item->is_promoted == 1): ?>
                                        <strong><?php echo date_difference($item->promote_end_date, date('Y-m-d H:i:s')); ?></strong>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $user = get_user($item->user_id);
                                    if (!empty($user)): ?>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-username">
                                            <?php echo html_escape($user->username); ?>
                                        </a>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans("select_option"); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans("view_details"); ?></a>
                                            </li>
                                            <?php if ($item->is_promoted == 1): ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="remove_from_featured('<?php echo html_escape($item->id); ?>');"><i class="fa fa-minus option-icon"></i><?php echo trans("remove_from_featured"); ?></a>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="$('#day_count_product_id').val('<?php echo html_escape($item->id); ?>');" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus option-icon"></i><?php echo trans("add_to_featured"); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?= generate_dash_url("edit_product"); ?>/<?= $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?php echo trans("edit"); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('product_controller/delete_product','<?php echo $item->id; ?>','<?php echo trans("confirm_product"); ?>');"><i class="fa fa-times option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('product_controller/delete_product_permanently','<?php echo $item->id; ?>','<?php echo trans("confirm_product_permanent"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete_permanently'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                            <?php if (count($products) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_products('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <?php echo form_open('product_controller/add_remove_featured_products'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo trans('add_to_featured'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?php echo trans('day_count'); ?></label>
                    <input type="hidden" class="form-control" name="product_id" id="day_count_product_id" value="">
                    <input type="hidden" class="form-control" name="is_ajax" value="0">
                    <input type="number" class="form-control" name="day_count" placeholder="<?php echo trans('day_count'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?= trans("submit") ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= trans("close") ?></button>
            </div>
            <?php echo form_close(); ?><!-- form end -->
        </div>

    </div>
</div>
