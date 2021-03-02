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
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <?php echo form_open($form_action, ['method' => 'GET']); ?>

                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?php echo trans("show"); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>

                                <div class="item-table-filter">
                                    <label><?php echo trans("search"); ?></label>
                                    <input name="order_number" class="form-control" placeholder="<?php echo trans("order_number"); ?>" type="search" value="<?php echo html_escape($this->input->get('order_number', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>

                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('order_number'); ?></th>
                            <th><?php echo trans('buyer'); ?></th>
                            <th><?php echo trans('first_name'); ?></th>
                            <th><?php echo trans('last_name'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($invoices as $item): ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td><?php echo $item->order_number; ?></td>
                                <td><?php echo $item->client_username; ?></td>
                                <td><?php echo $item->client_first_name; ?></td>
                                <td><?php echo $item->client_last_name; ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>invoice/<?php echo $item->order_number; ?>" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_invoice"); ?></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($invoices)): ?>
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
