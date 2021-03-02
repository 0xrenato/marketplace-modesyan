<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= html_escape($title); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <?php $this->load->view('dashboard/product/_filter_products'); ?>

                    <table class="table table-bordered table-striped table-products" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('product'); ?></th>
                            <th><?php echo trans('sku'); ?></th>
                            <th><?php echo trans('product_type'); ?></th>
                            <th><?php echo trans('category'); ?></th>
                            <?php if (!empty($promote_status)): ?>
                                <th><?php echo trans('purchased_plan'); ?></th>
                            <?php endif; ?>
                            <th><?= $this->general_settings->classified_ads_system == 1 ? trans("stock") . "/" . trans("status") : trans("stock"); ?></th>
                            <th><?php echo trans('page_views'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>
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
                                    <?php if (!empty($promote_status)): ?>
                                        <td>
                                            <?php if ($item->is_draft != 1):
                                                if ($item->is_promoted == 1 && $item->promote_plan != "none"):
                                                    echo $item->promote_plan;
                                                else: ?>
                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalPricing" onclick="$('.pricing_product_id').val(<?= $item->id; ?>);"><i class="fa fa-plus"></i>&nbsp;<?= trans("promote"); ?></button>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td class="white-space-nowrap"><?= get_product_stock_status($item); ?></td>
                                    <td><?php echo $item->pageviews; ?></td>
                                    <td><?php echo formatted_date($item->created_at); ?></td>
                                    <td style="width: 120px;">
                                        <div class="btn-group btn-group-option">
                                            <a href="<?php echo generate_dash_url("edit_product") . "/" . $item->id; ?>" class="btn btn-sm btn-default btn-edit" data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick="delete_product(<?php echo $item->id; ?>,'<?php echo trans("confirm_product"); ?>');"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($products)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($products)): ?>
                    <div class="number-of-entries">
                        <span><?= trans("number_of_entries"); ?>:</span>&nbsp;&nbsp;<strong><?= $num_rows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<?php $this->load->view('dashboard/product/_modal_pricing'); ?>

