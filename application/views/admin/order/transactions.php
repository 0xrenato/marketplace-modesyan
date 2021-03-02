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
                    <?php $this->load->view('admin/order/_filter_transactions'); ?>
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('order'); ?></th>
                            <th><?php echo trans('payment_method'); ?></th>
                            <th><?php echo trans('payment_id'); ?></th>
                            <th><?php echo trans('user'); ?></th>
                            <th><?php echo trans('currency'); ?></th>
                            <th><?php echo trans('payment_amount'); ?></th>
                            <th><?php echo trans('payment_status'); ?></th>
                            <th><?php echo trans('ip_address'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($transactions as $item): ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td class="order-number-table">
                                    #<?php
                                    $order = $this->order_admin_model->get_order($item->order_id);
                                    if (!empty($order)):
                                        echo $order->order_number;
                                    endif; ?>
                                </td>
                                <td><?= get_payment_method($item->payment_method); ?></td>
                                <td><?php echo $item->payment_id; ?></td>
                                <td>
                                    <?php if ($item->user_id == 0): ?>
                                        <label class="label bg-olive"><?php echo trans("guest"); ?></label>
                                    <?php else:
                                        $user = get_user($item->user_id);
                                        if (!empty($user)):?>
                                            <div class="table-orders-user">
                                                <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
                                                    <?php echo html_escape($user->username); ?>
                                                </a>
                                            </div>
                                        <?php endif;
                                    endif;
                                    ?>
                                </td>
                                <td><?php echo $item->currency; ?></td>
                                <td><?php echo $item->payment_amount; ?></td>
                                <td><?php echo get_payment_status($item->payment_status); ?></td>
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
                                                <a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_transaction_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
