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
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th scope="col"><?php echo trans("withdraw_method"); ?></th>
                            <th scope="col"><?php echo trans("withdraw_amount"); ?></th>
                            <th scope="col"><?php echo trans("status"); ?></th>
                            <th scope="col"><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($payouts)): ?>
                            <?php foreach ($payouts as $payout): ?>
                                <tr>
                                    <td><?php echo trans($payout->payout_method); ?></td>
                                    <td><?php echo price_formatted($payout->amount, $payout->currency); ?></td>
                                    <td>
                                        <?php if ($payout->status == 1): ?>
                                            <label class="label label-success"><?= trans("completed"); ?></label>
                                        <?php else: ?>
                                            <label class="label label-warning"><?= trans("pending"); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo formatted_date($payout->created_at); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($payouts)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($payouts)): ?>
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

