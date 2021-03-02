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
                        <?php $this->load->view('admin/featured/_filter_transactions'); ?>
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('payment_method'); ?></th>
                            <th><?php echo trans('payment_id'); ?></th>
                            <th><?php echo trans('user'); ?></th>
                            <th><?php echo trans('product_id'); ?></th>
                            <th><?php echo trans('currency'); ?></th>
                            <th><?php echo trans('payment_amount'); ?></th>
                            <th><?php echo trans('payment_status'); ?></th>
                            <th><?php echo trans('purchased_plan'); ?></th>
                            <th><?php echo trans('ip_address'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($transactions as $item): ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td><?= get_payment_method($item->payment_method); ?></td>
                                <td><?php echo $item->payment_id; ?></td>
                                <td>
                                    <?php $user = get_user($item->user_id);
                                    if (!empty($user)):?>
                                        <div class="table-orders-user">
                                            <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
                                                <?php echo html_escape($user->username); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $item->product_id; ?></td>
                                <td><?php echo $item->currency; ?></td>
                                <td><?php echo $item->payment_amount; ?></td>
                                <td>
                                    <?php if ($item->payment_status == "awaiting_payment"):
                                        echo trans("awaiting_payment");
                                    else:
                                        echo $item->payment_status;
                                    endif; ?>
                                </td>
                                <td><?php echo $item->purchased_plan; ?></td>
                                <td><?php echo $item->ip_address; ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <?php $product = get_product($item->product_id);
                                            if (!empty($product)):
                                                if ($product->is_promoted != 1): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="$('#day_count_product_id').val('<?= $item->product_id; ?>');$('#input_transaction_id').val('<?= $item->id; ?>');" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus option-icon"></i><?php echo trans('add_to_featured'); ?></a>
                                                    </li>
                                                <?php endif;
                                            endif;
                                            ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('product_controller/delete_featured_transaction_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($transactions)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
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
                    <input type="hidden" class="form-control" name="transaction_id" id="input_transaction_id" value="">
                    <input type="hidden" class="form-control" name="is_ajax" value="0">
                    <input type="number" class="form-control" name="day_count" placeholder="<?php echo trans('day_count'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo trans("submit"); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
            </div>
            <?php echo form_close(); ?><!-- form end -->
        </div>

    </div>
</div>
