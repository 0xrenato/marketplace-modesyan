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
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <?php echo form_open($page_url, ['method' => 'GET']); ?>
                            <div class="item-table-filter">
                                <label><?php echo trans("payment_status"); ?></label>
                                <select name="payment_status" class="form-control custom-select">
                                    <option value="" selected><?php echo trans("all"); ?></option>
                                    <option value="payment_received" <?php echo ($this->input->get('payment_status', true) == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                                    <option value="awaiting_payment" <?php echo ($this->input->get('payment_status', true) == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
                                </select>
                            </div>

                            <div class="item-table-filter">
                                <label><?php echo trans("search"); ?></label>
                                <input name="q" class="form-control" placeholder="<?php echo trans("sale_id"); ?>" type="search" value="<?php echo str_slug(html_escape($this->input->get('q', true))); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
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
                            <th scope="col"><?php echo trans("sale"); ?></th>
                            <th scope="col"><?php echo trans("total"); ?></th>
                            <th scope="col"><?php echo trans("payment"); ?></th>
                            <th scope="col"><?php echo trans("status"); ?></th>
                            <th scope="col"><?php echo trans("date"); ?></th>
                            <th scope="col"><?php echo trans("options"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($sales)): ?>
                            <?php foreach ($sales as $sale):
                                $total = $this->order_model->get_seller_total_price($sale->id);
                                if (!empty($sale)):?>
                                    <tr>
                                        <td>#<?php echo $sale->order_number; ?></td>
                                        <td><?php echo price_formatted($total, $sale->price_currency); ?></td>
                                        <td>
                                            <?php if ($sale->payment_status == 'payment_received'):
                                                echo trans("payment_received");
                                            else:
                                                echo trans("awaiting_payment");
                                            endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($active_page == "sales"): ?>
                                                <label class="label label-success"><?= trans("order_processing"); ?></label>
                                            <?php else: ?>
                                                <label class="label label-default"><?= trans("completed"); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date("Y-m-d / h:i", strtotime($sale->created_at)); ?></td>
                                        <td>
                                            <a href="<?= generate_dash_url("sale"); ?>/<?php echo $sale->order_number; ?>" class="btn btn-sm btn-default btn-details">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo trans("details"); ?></a>
                                        </td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($sales)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($sales)): ?>
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

