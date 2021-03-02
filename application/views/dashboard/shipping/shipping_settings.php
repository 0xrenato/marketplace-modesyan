<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("shipping_zones"); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= generate_dash_url("add_shipping_zone"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= trans("add_shipping_zone"); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php if (!empty($this->session->flashdata('msg_shipping_zone'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th scope="col"><?= trans("zone_name"); ?></th>
                                    <th scope="col"><?= trans("regions"); ?></th>
                                    <th scope="col"><?= trans("shipping_methods"); ?></th>
                                    <th scope="col"><?= trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($shipping_zones)): ?>
                                    <?php foreach ($shipping_zones as $shipping_zone): ?>
                                        <tr>
                                            <td><?= @parse_serialized_name_array($shipping_zone->name_array, $this->selected_lang->id); ?></td>
                                            <td>
                                                <?php $locations = get_shipping_locations_by_zone($shipping_zone->id);
                                                if (!empty($locations)):
                                                    $i = 0;
                                                    foreach ($locations as $location):
                                                        if (!empty($location->country_name) && !empty($location->state_name)):?>
                                                            <span class="pull-left"><?= $i != 0 ? ", " : ''; ?><?= $location->country_name . "/" . $location->state_name; ?></span>
                                                        <?php
                                                        elseif (!empty($location->country_name) && empty($location->state_name)):?>
                                                            <span class="pull-left"><?= $i != 0 ? ", " : ''; ?><?= $location->country_name; ?></span>
                                                        <?php else: ?>
                                                            <span class="pull-left"><?= $i != 0 ? ", " : ''; ?><?= get_continent_name_by_key($location->continent_code); ?></span>
                                                        <?php endif;
                                                        $i++;
                                                    endforeach;
                                                endif; ?>
                                            </td>
                                            <td>
                                                <?php $methods = get_shipping_payment_methods_by_zone($shipping_zone->id);
                                                $i = 0;
                                                if (!empty($methods)):
                                                    foreach ($methods as $method): ?>
                                                        <span class="pull-left"><?= $i != 0 ? ", " : ''; ?><?= @parse_serialized_name_array($method->name_array, $this->selected_lang->id); ?></span>
                                                        <?php $i++;
                                                    endforeach;
                                                endif; ?>
                                            </td>
                                            <td style="width: 120px;">
                                                <div class="btn-group btn-group-option">
                                                    <a href="<?= generate_dash_url("edit-shipping-zone"); ?>/<?= $shipping_zone->id; ?>" class="btn btn-sm btn-default btn-edit" data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick="delete_item('dashboard_controller/delete_shipping_zone_post','<?= $shipping_zone->id; ?>','<?= trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="box box-sm">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("shipping_classes"); ?></h3>
                </div>
                <div class="right">
                    <a href="javascript:void(0)" class="btn btn-success btn-add-new" data-toggle="modal" data-target="#modalAddShippingClass">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= trans("add_shipping_class"); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php if (!empty($this->session->flashdata('msg_shipping_class'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive table-delivery-times">
                            <table class="table table-bordered table-striped dataTableNoSort" role="grid">
                                <thead>
                                <tr role="row">
                                    <th scope="col"><?= trans("option"); ?></th>
                                    <th scope="col"><?= trans("status"); ?></th>
                                    <th scope="col"><?= trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($shipping_classes)): ?>
                                    <?php foreach ($shipping_classes as $shipping_class): ?>
                                        <tr>
                                            <td><?= @parse_serialized_name_array($shipping_class->name_array, $this->selected_lang->id); ?></td>
                                            <td>
                                                <?php if ($shipping_class->status == 1): ?>
                                                    <span class="text-success"><?php echo trans('active'); ?></span>
                                                <?php else: ?>
                                                    <span class="text-danger"><?php echo trans('inactive'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="width: 120px;">
                                                <div class="btn-group btn-group-option">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalEditShippingClass<?= $shipping_class->id; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick="delete_item('dashboard_controller/delete_shipping_class_post','<?= $shipping_class->id; ?>','<?= trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <div id="modalEditShippingClass<?= $shipping_class->id; ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                                        <h4 class="modal-title"><?= trans("edit_shipping_class"); ?></h4>
                                                    </div>
                                                    <?php echo form_open("edit-shipping-class-post"); ?>
                                                    <input type="hidden" name="id" value="<?= $shipping_class->id; ?>">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo trans("name"); ?></label>
                                                            <?php foreach ($this->languages as $language): ?>
                                                                <input type="text" name="name_lang_<?= $language->id; ?>" value="<?= @parse_serialized_name_array($shipping_class->name_array, $language->id); ?>" class="form-control form-input m-b-5" placeholder="<?= $language->name; ?>" maxlength="255" required>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-xs-12">
                                                                    <label><?= trans("status"); ?></label>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 col-custom-option">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" name="status" value="1" id="status_<?= $shipping_class->id; ?>_1" class="custom-control-input" <?= $shipping_class->status == 1 ? 'checked' : ''; ?>>
                                                                        <label for="status_<?= $shipping_class->id; ?>_1" class="custom-control-label"><?= trans("enable"); ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 col-custom-option">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" name="status" value="0" id="status_<?= $shipping_class->id; ?>_2" class="custom-control-input" <?= $shipping_class->status != 1 ? 'checked' : ''; ?>>
                                                                        <label for="status_<?= $shipping_class->id; ?>_2" class="custom-control-label"><?= trans("disable"); ?></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
        <div class="alert alert-info alert-large">
            <?php echo trans("shipping_classes_exp"); ?>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="box box-sm">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("shipping_delivery_times"); ?></h3>
                </div>
                <div class="right">
                    <a href="javascript:void(0)" class="btn btn-success btn-add-new" data-toggle="modal" data-target="#modalAddDeliveryTime">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= trans("add_delivery_time"); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (!empty($this->session->flashdata('msg_delivery_time'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive table-delivery-times">
                            <table class="table table-bordered table-striped dataTableNoSort" role="grid">
                                <thead>
                                <tr role="row">
                                    <th scope="col"><?= trans("option"); ?></th>
                                    <th scope="col"><?= trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($shipping_delivery_times)): ?>
                                    <?php foreach ($shipping_delivery_times as $delivery_time): ?>
                                        <tr>
                                            <td><?= @parse_serialized_option_array($delivery_time->option_array, $this->selected_lang->id); ?></td>
                                            <td style="width: 120px;">
                                                <div class="btn-group btn-group-option">
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalEditDeliveryTime<?= $delivery_time->id; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick="delete_item('dashboard_controller/delete_shipping_delivery_time_post','<?= $delivery_time->id; ?>','<?= trans("confirm_delete"); ?>');"><i class="fa fa-trash-o"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <div id="modalEditDeliveryTime<?= $delivery_time->id; ?>" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                                        <h4 class="modal-title"><?= trans("edit_delivery_time"); ?></h4>
                                                    </div>
                                                    <?php echo form_open("edit-shipping-delivery-time-post"); ?>
                                                    <input type="hidden" name="id" value="<?= $delivery_time->id; ?>">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo trans("option"); ?></label>
                                                            <?php foreach ($this->languages as $language): ?>
                                                                <input type="text" name="option_lang_<?= $language->id; ?>" value="<?= @parse_serialized_option_array($delivery_time->option_array, $language->id); ?>" class="form-control form-input m-b-5" placeholder="<?= $language->name; ?>" maxlength="255" required>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
        <div class="alert alert-info alert-large">
            <?php echo trans("shipping_delivery_times_exp"); ?>
        </div>
    </div>
</div>

<div id="modalAddShippingClass" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="modal-title"><?= trans("add_shipping_class"); ?></h4>
            </div>
            <?php echo form_open("add-shipping-class-post"); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("name"); ?></label>
                    <?php foreach ($this->languages as $language): ?>
                        <input type="text" name="name_lang_<?= $language->id; ?>" class="form-control form-input m-b-5" placeholder="<?= $language->name; ?>" maxlength="255" required>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?= trans("status"); ?></label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="status" value="1" id="status_1" class="custom-control-input" checked>
                                <label for="status_1" class="custom-control-label"><?= trans("enable"); ?></label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="status" value="0" id="status_2" class="custom-control-input">
                                <label for="status_2" class="custom-control-label"><?= trans("disable"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div id="modalAddDeliveryTime" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="modal-title"><?= trans("add_delivery_time"); ?></h4>
            </div>
            <?php echo form_open("add-shipping-delivery-time-post"); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label"><?php echo trans("option"); ?></label>
                    <?php foreach ($this->languages as $language): ?>
                        <input type="text" name="option_lang_<?= $language->id; ?>" class="form-control form-input m-b-5" placeholder="<?= $language->name; ?>" maxlength="255" required>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?= trans("submit"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<style>
    .table-delivery-times .dataTables_length, .table-delivery-times .dataTables_filter {
        display: none;
    }
</style>


