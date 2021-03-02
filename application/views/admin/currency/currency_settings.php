<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("currency_settings"); ?></h3>
            </div>
            <?php echo form_open('admin_controller/currency_settings_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_settings'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('default_currency'); ?></label>
                    <select name="default_currency" class="form-control">
                        <?php if (!empty($currencies)):
                            foreach ($currencies as $item):
                                if ($item->status == 1):?>
                                    <option value="<?php echo $item->code; ?>" <?php echo ($this->payment_settings->default_currency == $item->code) ? 'selected' : ''; ?>><?php echo $item->name . " (" . $item->symbol . ")"; ?></option>
                                <?php endif;
                            endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans('allow_all_currencies_classified_ads'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="allow_all_currencies_for_classied" value="1" id="allow_1" class="square-purple" <?php echo ($this->payment_settings->allow_all_currencies_for_classied == 1) ? 'checked' : ''; ?>>
                            <label for="allow_1" class="option-label"><?php echo trans("yes"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="allow_all_currencies_for_classied" value="0" id="allow_2" class="square-purple" <?php echo ($this->payment_settings->allow_all_currencies_for_classied != 1) ? 'checked' : ''; ?>>
                            <label for="allow_2" class="option-label"><?php echo trans("no"); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("currency_converter"); ?></h3>
            </div>
            <?php echo form_open('admin_controller/currency_converter_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('msg_converter'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans("status"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="currency_converter" value="1" id="currency_converter_1" class="square-purple" <?php echo ($this->payment_settings->currency_converter == 1) ? 'checked' : ''; ?>>
                            <label for="currency_converter_1" class="option-label"><?php echo trans("enable"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="currency_converter" value="0" id="currency_converter_2" class="square-purple" <?php echo ($this->payment_settings->currency_converter != 1) ? 'checked' : ''; ?>>
                            <label for="currency_converter_2" class="option-label"><?php echo trans("disable"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 m-b-5">
                            <label><?php echo trans("automatically_update_exchange_rates"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="auto_update_exchange_rates" value="1" id="auto_update_exchange_rates_1" class="square-purple" <?php echo ($this->payment_settings->auto_update_exchange_rates == 1) ? 'checked' : ''; ?>>
                            <label for="auto_update_exchange_rates_1" class="option-label"><?php echo trans("yes"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="auto_update_exchange_rates" value="0" id="auto_update_exchange_rates_2" class="square-purple" <?php echo ($this->payment_settings->auto_update_exchange_rates != 1) ? 'checked' : ''; ?>>
                            <label for="auto_update_exchange_rates_2" class="option-label"><?php echo trans("no"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo trans("currency_converter_api"); ?></label>
                    <select name="currency_converter_api" class="form-control">
                        <option value=""><?= trans("select"); ?></option>
                        <option value="fixer" <?= $this->payment_settings->currency_converter_api == 'fixer' ? 'selected' : ''; ?>>Fixer.io</option>
                        <option value="currencyapi" <?= $this->payment_settings->currency_converter_api == 'currencyapi' ? 'selected' : ''; ?>>Currencyapi.net</option>
                        <option value="openexchangerates" <?= $this->payment_settings->currency_converter_api == 'openexchangerates' ? 'selected' : ''; ?>>Openexchangerates.org</option>
                    </select>
                    <input type="text" name="currency_converter_api_key" value="<?= $this->payment_settings->currency_converter_api_key; ?>" class="form-control m-t-5" placeholder="<?= trans("access_key"); ?>">
                </div>

            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("currencies"); ?></h3>
                </div>
                <div class="right">
                    <?php if ($this->payment_settings->currency_converter == 1):
                        echo form_open('admin_controller/update_currency_rates', ['class' => 'inline']); ?>
                        <button class="btn btn-info btn-add-new"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?= trans("update_exchange_rates"); ?></button>
                        <?php echo form_close();
                    endif; ?>
                    <a href="<?php echo admin_url(); ?>add-currency" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans("add_currency"); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="table-responsive">
                        <!-- include message block -->
                        <div class="col-sm-12">
                            <?php if (!empty($this->session->flashdata('msg_table'))):
                                $this->load->view('admin/includes/_messages');
                            endif; ?>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped" id="cs_datatable_currency" role="grid">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('currency'); ?></th>
                                    <th><?php echo trans('currency_code'); ?></th>
                                    <th><?php echo trans('currency_symbol'); ?></th>
                                    <th><?php echo trans('exchange_rate'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($currencies as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td>
                                            <?php echo html_escape($item->name); ?>&nbsp;
                                            <?php if ($item->status == 1): ?>
                                                <label class="label label-success pull-right"><?= trans("active"); ?></label>
                                            <?php else: ?>
                                                <label class="label label-default pull-right"><?= trans("inactive"); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo html_escape($item->code); ?></td>
                                        <td><?php echo html_escape($item->symbol); ?></td>
                                        <td>
                                            <?php if ($this->payment_settings->default_currency == $item->code):
                                                echo trans("default"); ?>
                                            <?php else: ?>
                                                <input type="number" class="form-control input-exchange-rate" value="<?= $item->exchange_rate; ?>" data-currency-id="<?= $item->id; ?>" min="0" max="999999999" step="0.00001" placeholder="<?= trans("exchange_rate"); ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-currency/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_currency_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</div>