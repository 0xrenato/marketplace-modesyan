<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('reviews'); ?></h3>
        </div>
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
                    <table class="table table-bordered table-striped data_table" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('user'); ?></th>
                            <th><?php echo trans('review'); ?></th>
                            <th style="min-width: 20%"><?php echo trans('product'); ?></th>
                            <th><?php echo trans('ip_address'); ?></th>
                            <th style="min-width: 10%"><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($reviews as $item):
                            $product = get_active_product($item->product_id); ?>
                            <tr>
                                <td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td><?php echo html_escape($item->user_username); ?></td>
                                <td class="break-word">
                                    <div class="pull-left" style="width: 100%;">
                                        <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                    </div>
                                    <p class="pull-left">
                                        <?php echo html_escape($item->review); ?>
                                    </p>
                                </td>
                                <td style="width: 30%;">
                                    <?php if (!empty($product)): ?>
                                        <a href="<?= generate_product_url($product); ?>" target="_blank">
                                            <?= get_product_title($product); ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $item->ip_address; ?></td>
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
                                                <a href="javascript:void(0)" onclick="delete_item('product_controller/delete_review','<?php echo $item->id; ?>','<?php echo trans("confirm_review"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="pull-left">
                            <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_reviews('<?php echo trans("confirm_reviews"); ?>');"><?php echo trans('delete'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
