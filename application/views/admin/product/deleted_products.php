<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="javascript:void(0)" onclick="restore_product('<?php echo $item->id; ?>');"><i class="fa fa-reply option-icon"></i><?php echo trans('restore'); ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans('view_details'); ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo generate_dash_url("edit_product") . "/" . $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
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
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_products_permanently('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
