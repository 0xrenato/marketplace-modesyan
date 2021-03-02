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
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open("", ['method' => 'GET']); ?>

                            <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                <label><?php echo trans("show"); ?></label>
                                <select name="show" class="form-control">
                                    <option value="15" <?= input_get('show') == '15' ? 'selected' : ''; ?>>15</option>
                                    <option value="30" <?= input_get('show') == '30' ? 'selected' : ''; ?>>30</option>
                                    <option value="60" <?= input_get('show') == '60' ? 'selected' : ''; ?>>60</option>
                                    <option value="100" <?= input_get('show') == '100' ? 'selected' : ''; ?>>100</option>
                                </select>
                            </div>
                            <div class="item-table-filter">
                                <label><?php echo trans("search"); ?></label>
                                <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>
                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?= trans("id"); ?></th>
                            <th><?= trans("user"); ?></th>
                            <th><?= trans("membership_plan"); ?></th>
                            <th><?= trans("payment_method"); ?></th>
                            <th><?= trans("payment_id"); ?></th>
                            <th><?= trans("payment_amount"); ?></th>
                            <th><?= trans("payment_status"); ?></th>
                            <th><?= trans("ip_address"); ?></th>
                            <th><?= trans("date"); ?></th>
                            <th class="max-width-120"><?= trans("options"); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($transactions as $item): ?>
                            <tr>
                                <td><?= $item->id; ?></td>
                                <td><?php $user = get_user($item->user_id);
                                    if (!empty($user)):?>
                                        <div class="table-orders-user">
                                            <a href="<?= generate_profile_url($user->slug); ?>" target="_blank">
                                                <img src="<?= get_user_avatar($user); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
                                                <?= html_escape($user->username); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?= $item->plan_title; ?></td>
                                <td><?= get_payment_method($item->payment_method); ?></td>
                                <td><?= $item->payment_id; ?></td>
                                <td><?= $item->payment_amount; ?>&nbsp;(<?= $item->currency; ?>)</td>
                                <td>
                                    <?= get_payment_status($item->payment_status); ?>
                                    <?php if ($item->payment_status == "awaiting_payment"):
                                        echo form_open('membership_controller/approve_payment_post'); ?>
                                        <input type="hidden" name="id" value="<?= $item->id; ?>">
                                        <button type="submit" class="btn btn-sm btn-success m-t-5"><i class="fa fa-check"></i>&nbsp;<?= trans("approve"); ?></button>
                                        <?php echo form_close();
                                    endif; ?>
                                </td>
                                <td><?= $item->ip_address; ?></td>
                                <td><?= formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="btn-group btn-group-option">
                                        <a href="<?php echo base_url(); ?>invoice-membership/<?= $item->id; ?>" class="btn btn-sm btn-default btn-edit" target="_blank"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_invoice"); ?></a>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="delete_item('membership_controller/delete_transaction_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
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
                </div>
            </div>
            <div class="col-sm-12">
                <?php if (!empty($transactions)): ?>
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
