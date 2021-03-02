<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if (!empty($method)):
    $option_unique_id = $method->id;
    $selected_option = $method->method_type; ?>
    <div id="row_shipping_method_<?= $option_unique_id; ?>" class="row">
        <div class="col-sm-12">
            <input type="hidden" name="option_unique_id[]" value="<?= $option_unique_id; ?>">
            <input type="hidden" name="method_type_<?= $option_unique_id; ?>" value="<?= $selected_option; ?>">
            <input type="hidden" name="method_operation_<?= $option_unique_id; ?>" value="edit">
            <?php if ($selected_option == "flat_rate"): ?>
                <div class="response-shipping-method">
                    <span class="title"><?= @parse_serialized_name_array($method->name_array, $this->selected_lang->id); ?></span>
                    <div id="modalMethod<?= $option_unique_id; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                    <h4 class="modal-title"><?= trans($selected_option); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group m-b-10">
                                        <label class="control-label"><?= trans("method_name"); ?></label>
                                        <?php foreach ($this->languages as $language): ?>
                                            <input type="text" name="method_name_<?= $option_unique_id; ?>_lang_<?= $language->id; ?>" class="form-control form-input m-b-5" value="<?= @parse_serialized_name_array($method->name_array, $language->id); ?>" placeholder="<?= $language->name; ?>" maxlength="255">
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?= trans("cost_calculation_type"); ?></label>
                                        <select name="flat_rate_cost_calculation_type_<?= $option_unique_id; ?>" class="form-control custom-select">
                                            <option value="each_product" <?= $method->flat_rate_cost_calculation_type == "each_product" ? "selected" : ""; ?>><?= trans("charge_shipping_for_each_product"); ?></option>
                                            <option value="each_different_product" <?= $method->flat_rate_cost_calculation_type == "each_different_product" ? "selected" : ""; ?>><?= trans("charge_shipping_for_each_different_product"); ?></option>
                                            <option value="cart_total" <?= $method->flat_rate_cost_calculation_type == "cart_total" ? "selected" : ""; ?>><?= trans("fixed_shipping_cost_for_cart_total"); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <label class="control-label"><?= trans("cost"); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                            <input type="text" name="flat_rate_cost_<?= $option_unique_id; ?>" class="form-control form-input price-input" value="<?= get_price($method->flat_rate_cost, 'input'); ?>" placeholder="<?php echo $this->input_initial_price; ?>" maxlength="19">
                                        </div>
                                    </div>
                                    <?php if (!empty($shipping_classes)): ?>
                                        <div class="form-group">
                                            <label><?= trans("shipping_class_costs"); ?></label>
                                            <?php foreach ($shipping_classes as $shipping_class):
                                                $class_cost = get_shipping_class_cost_by_method($method->flat_rate_class_costs_array, $shipping_class->id);
                                                if (!empty($class_cost)):
                                                    $class_cost = get_price($class_cost, "input");
                                                endif; ?>
                                                <div class="input-group m-b-5">
                                                    <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                                    <input type="text" name="flat_rate_cost_<?= $option_unique_id; ?>_class_<?= $shipping_class->id; ?>" class="form-control form-input price-input" value="<?= $class_cost; ?>"
                                                           placeholder="<?= @parse_serialized_name_array($shipping_class->name_array, $this->selected_lang->id); ?>" maxlength="19">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <label><?= trans("status"); ?></label>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-custom-option">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="status_<?= $option_unique_id; ?>" value="1" id="status_<?= $option_unique_id; ?>_1" class="custom-control-input" <?= $method->status == 1 ? "checked" : ""; ?>>
                                                    <label for="status_<?= $option_unique_id; ?>_1" class="custom-control-label"><?= trans("enable"); ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-custom-option">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="status_<?= $option_unique_id; ?>" value="0" id="status_<?= $option_unique_id; ?>_2" class="custom-control-input" <?= $method->status != 1 ? "checked" : ""; ?>>
                                                    <label for="status_<?= $option_unique_id; ?>_2" class="custom-control-label"><?= trans("disable"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-option">
                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalMethod<?= $option_unique_id; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick='delete_shipping_method("<?= $option_unique_id; ?>","<?= trans("confirm_delete"); ?>");'><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            <?php elseif ($selected_option == "local_pickup"): ?>
                <div class="response-shipping-method">
                    <span class="title"><?= @parse_serialized_name_array($method->name_array, $this->selected_lang->id); ?></span>
                    <div id="modalMethod<?= $option_unique_id; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                    <h4 class="modal-title"><?= trans($selected_option); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group m-b-10">
                                        <label class="control-label"><?= trans("method_name"); ?></label>
                                        <?php foreach ($this->languages as $language): ?>
                                            <input type="text" name="method_name_<?= $option_unique_id; ?>_lang_<?= $language->id; ?>" class="form-control form-input m-b-5" value="<?= @parse_serialized_name_array($method->name_array, $language->id); ?>" placeholder="<?= $language->name; ?>" maxlength="255">
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <label class="control-label"><?= trans("cost"); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                            <input type="text" name="local_pickup_cost_<?= $option_unique_id; ?>" class="form-control form-input price-input" value="<?= get_price($method->local_pickup_cost, 'input'); ?>" placeholder="<?php echo $this->input_initial_price; ?>" maxlength="19">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <label><?= trans("status"); ?></label>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-custom-option">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="status_<?= $option_unique_id; ?>" value="1" id="status_<?= $option_unique_id; ?>_1" class="custom-control-input" <?= $method->status == 1 ? "checked" : ""; ?>>
                                                    <label for="status_<?= $option_unique_id; ?>_1" class="custom-control-label"><?= trans("enable"); ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-custom-option">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="status_<?= $option_unique_id; ?>" value="0" id="status_<?= $option_unique_id; ?>_2" class="custom-control-input" <?= $method->status != 1 ? "checked" : ""; ?>>
                                                    <label for="status_<?= $option_unique_id; ?>_2" class="custom-control-label"><?= trans("disable"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-option">
                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalMethod<?= $option_unique_id; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick='delete_shipping_method("<?= $option_unique_id; ?>","<?= trans("confirm_delete"); ?>");'><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            <?php elseif ($selected_option == "free_shipping"): ?>
                <div class="response-shipping-method">
                    <span class="title"><?= @parse_serialized_name_array($method->name_array, $this->selected_lang->id); ?></span>
                    <div id="modalMethod<?= $option_unique_id; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                    <h4 class="modal-title"><?= trans($selected_option); ?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group m-b-10">
                                        <label class="control-label"><?= trans("method_name"); ?></label>
                                        <?php foreach ($this->languages as $language): ?>
                                            <input type="text" name="method_name_<?= $option_unique_id; ?>_lang_<?= $language->id; ?>" class="form-control form-input m-b-5" value="<?= @parse_serialized_name_array($method->name_array, $language->id); ?>" placeholder="<?= $language->name; ?>" maxlength="255">
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <label class="control-label"><?= trans("minimum_order_amount"); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><?= $this->default_currency->symbol; ?></span>
                                            <input type="text" name="free_shipping_min_amount_<?= $option_unique_id; ?>" class="form-control form-input price-input" value="<?= get_price($method->free_shipping_min_amount, 'input'); ?>" placeholder="<?php echo $this->input_initial_price; ?>" maxlength="19">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <label><?= trans("status"); ?></label>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-custom-option">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="status_<?= $option_unique_id; ?>" value="1" id="status_<?= $option_unique_id; ?>_1" class="custom-control-input" <?= $method->status == 1 ? "checked" : ""; ?>>
                                                    <label for="status_<?= $option_unique_id; ?>_1" class="custom-control-label"><?= trans("enable"); ?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-custom-option">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" name="status_<?= $option_unique_id; ?>" value="0" id="status_<?= $option_unique_id; ?>_2" class="custom-control-input" <?= $method->status != 1 ? "checked" : ""; ?>>
                                                    <label for="status_<?= $option_unique_id; ?>_2" class="custom-control-label"><?= trans("disable"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group btn-group-option">
                        <a href="javascript:void(0)" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalMethod<?= $option_unique_id; ?>"><span data-toggle="tooltip" title="<?= trans('edit'); ?>"><i class="fa fa-edit"></i></span></a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-default" data-toggle="tooltip" title="<?= trans('delete'); ?>" onclick='delete_shipping_method("<?= $option_unique_id; ?>","<?= trans("confirm_delete"); ?>");'><i class="fa fa-trash-o"></i></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
