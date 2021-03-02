<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('custom_fields'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>add-custom-field" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans('add_custom_field'); ?>
                    </a>
                </div>
            </div><!-- /.box-header -->

            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data_table" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('name'); ?></th>
                                    <th><?php echo trans('type'); ?></th>
                                    <th>&nbsp;</th>
                                    <th><?php echo trans('required'); ?></th>
                                    <th><?php echo trans('order'); ?></th>
                                    <th><?php echo trans('status'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($fields as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td><?php echo parse_serialized_name_array($item->name_array, $this->selected_lang->id); ?></td>
                                        <td><?php echo trans($item->field_type); ?></td>
                                        <td>
                                            <?php echo form_open_multipart('category_controller/add_remove_custom_field_filters_post'); ?>
                                            <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                                            <?php if ($item->field_type == 'checkbox' || $item->field_type == 'radio_button' || $item->field_type == 'dropdown'):
                                                if ($item->is_product_filter == 1):?>
                                                    <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i>&nbsp;<?php echo trans('remove_from_product_filters'); ?></button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-success"><i class="fa fa-plus"></i>&nbsp;<?php echo trans('add_to_product_filters'); ?></button>
                                                <?php endif;
                                            endif; ?>
                                            <?php echo form_close(); ?>
                                        </td>
                                        <td>
                                            <?php if ($item->is_required == 1) {
                                                echo trans("yes");
                                            } else {
                                                echo trans("no");
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo html_escape($item->field_order); ?></td>
                                        <td>
                                            <?php if ($item->status == 1): ?>
                                                <label class="label bg-olive label-table"><?php echo trans('active'); ?></label>
                                            <?php else: ?>
                                                <label class="label bg-danger label-table"><?php echo trans('inactive'); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-custom-field/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('category_controller/delete_custom_field_post','<?php echo $item->id; ?>','<?php echo trans("confirm_custom_field"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
