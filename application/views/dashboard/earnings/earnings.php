<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row m-b-30">
    <div class="col-sm-12">
        <div class="small-boxes-dashboard-earnings">
            <div class="small-boxes-dashboard">
                <div class="col-sm-12 col-xs-12 p-0">
                    <div class="small-box-dashboard">
                        <h3 class="total"><?= price_formatted($this->auth_user->balance, $this->payment_settings->default_currency); ?></h3>
                        <span class="text-muted"><?= trans("balance"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z"/>
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z"/>
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open(current_url(), ['method' => 'GET']); ?>
                            <div class="item-table-filter">
                                <label><?php echo trans("search"); ?></label>
                                <input name="q" class="form-control" placeholder="<?php echo trans("order_id"); ?>" type="search" value="<?php echo str_slug(html_escape($this->input->get('q', true))); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>
                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="btn bg-purple btn-filter"><?php echo trans("filter"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                    <table class="table table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th scope="col"><?php echo trans("order"); ?></th>
                            <th scope="col"><?php echo trans("total"); ?></th>
                            <th scope="col"><?php echo trans("commission_rate"); ?></th>
                            <th scope="col"><?php echo trans("shipping_cost"); ?></th>
                            <th scope="col"><?php echo trans("earned_amount"); ?></th>
                            <th scope="col"><?php echo trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($earnings)): ?>
                            <?php foreach ($earnings as $earning): ?>
                                <tr>
                                    <td>#<?php echo $earning->order_number; ?></td>
                                    <td><?php echo price_formatted($earning->price, $earning->currency); ?></td>
                                    <td><?php echo $earning->commission_rate; ?>%</td>
                                    <td><?php echo price_formatted($earning->shipping_cost, $earning->currency); ?></td>
                                    <td>
                                        <?php echo price_formatted($earning->earned_amount, $earning->currency);
                                        $order = get_order_by_order_number($earning->order_number);
                                        if (!empty($order) && $order->payment_method == "Cash On Delivery"):?>
                                            <span class="text-danger">(-<?php echo price_formatted($earning->earned_amount, $earning->currency); ?>)</span><br><small class="text-danger"><?php echo trans("cash_on_delivery"); ?></small>
                                        <?php endif; ?>
                                        <?php if ($this->payment_settings->currency_converter == 1 && $earning->exchange_rate > 0 && $earning->exchange_rate != 1):
                                            $total_earned = get_price($earning->earned_amount, 'decimal');
                                            $total_earned = $total_earned / $earning->exchange_rate;
                                            $total_earned = number_format($total_earned, 2, ".", ""); ?>
                                            <span>(<?= $this->default_currency->code . " " . $total_earned; ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo formatted_date($earning->created_at); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($earnings)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($earnings)): ?>
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

