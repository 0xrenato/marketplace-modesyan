<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shopping-cart shopping-cart-shipping">
                    <div class="row">
                        <div class="col-sm-12 col-lg-8">
                            <div class="left">
                                <h1 class="cart-section-title"><?php echo trans("checkout"); ?></h1>
                                <div class="tab-checkout tab-checkout-open m-t-0">
                                    <h2 class="title">1.&nbsp;&nbsp;<?php echo trans("shipping_information"); ?></h2>
                                    <?php $this->load->view('partials/_messages'); ?>

                                    <?php if (empty($shipping_addresses)): ?>
                                        <p class="text-muted"><?= trans("not_added_shipping_address"); ?></p>
                                        <p>
                                            <a href="javascript:void(0)" class="text-info link-add-new-shipping-option" data-toggle="modal" data-target="#modalAddAddress">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                </svg>
                                                <?= trans("add_new_address"); ?>
                                            </a>
                                        </p>
                                    <?php else: ?>
                                        <p class="text-right">
                                            <a href="javascript:void(0)" class="text-info link-add-new-shipping-option" data-toggle="modal" data-target="#modalAddAddress">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                </svg>
                                                <?= trans("add_new_address"); ?>
                                            </a>
                                        </p>
                                        <?php echo form_open("shipping-post", ['id' => 'form_validate']); ?>
                                        <p class="text-shipping-address"><?= trans("shipping_address"); ?></p>
                                        <div class="row">
                                            <?php if (!empty($shipping_addresses)):
                                                $i = 0;
                                                foreach ($shipping_addresses as $address):
                                                    $country = get_country($address->country_id);
                                                    $state = get_state($address->state_id); ?>
                                                    <div class="col-12 m-b-10">
                                                        <div class="shipping-address-box shipping-address-box-cart">
                                                            <div class="address-left">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input" id="option_shipping_address_<?= $address->id; ?>" name="shipping_address_id" value="<?= $address->id; ?>"
                                                                        <?= $selected_shipping_address_id == $address->id ? 'checked' : ''; ?> onchange="get_shipping_methods_by_location('<?= $address->state_id; ?>');" required>
                                                                    <label class="custom-control-label" for="option_shipping_address_<?= $address->id; ?>">
                                                                        <strong class="m-b-5"><?= html_escape($address->title); ?></strong>
                                                                        <p>
                                                                            <?= html_escape($address->address); ?>&nbsp;<?= html_escape($address->zip_code); ?>
                                                                            <?php if (!empty($address->city)):
                                                                                echo html_escape($address->city) . "/";
                                                                            endif;
                                                                            if (!empty($state->name)):
                                                                                echo html_escape($state->name) . "/";
                                                                            endif;
                                                                            if (!empty($country->name)):
                                                                                echo html_escape($country->name);
                                                                            endif; ?>
                                                                        </p>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="address-right">
                                                                <div class="dropdown dropdown-shipping-options">
                                                                    <button class="btn" type="button" data-toggle="dropdown">
                                                                        <svg width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                                        </svg>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modalAddress<?= $address->id; ?>"><?= trans("edit"); ?></a>
                                                                        <a href="javascript:void(0)" class="dropdown-item" onclick='delete_shipping_address("<?= $address->id; ?>","<?= trans("confirm_delete"); ?>");'><?= trans("delete"); ?></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 m-t-10">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="use_same_address_for_billing" value="1" id="use_same_address_for_billing" <?= $selected_same_address_for_billing == 1 ? 'checked' : ''; ?>>
                                                        <label for="use_same_address_for_billing" class="custom-control-label"><?php echo trans("use_same_address_for_billing"); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cart-form-billing-address" <?= empty($selected_same_address_for_billing) ? "style='display:block;'" : ""; ?>>
                                            <p class="text-shipping-address"><?= trans("billing_address"); ?></p>
                                            <div class="row">
                                                <?php if (!empty($shipping_addresses)):
                                                    foreach ($shipping_addresses as $address):
                                                        $country = get_country($address->country_id);
                                                        $state = get_state($address->state_id); ?>
                                                        <div class="col-12 m-b-10">
                                                            <div class="shipping-address-box shipping-address-box-cart">
                                                                <div class="address-left">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" class="custom-control-input" id="option_billing_address_<?= $address->id; ?>" name="billing_address_id" value="<?= $address->id; ?>" <?= $selected_billing_address_id == $address->id ? 'checked' : ''; ?> required>
                                                                        <label class="custom-control-label" for="option_billing_address_<?= $address->id; ?>">
                                                                            <strong class="m-b-5"><?= html_escape($address->title); ?></strong>
                                                                            <p>
                                                                                <?= html_escape($address->address); ?>&nbsp;<?= html_escape($address->zip_code); ?>
                                                                                <?php if (!empty($address->city)):
                                                                                    echo html_escape($address->city) . "/";
                                                                                endif;
                                                                                if (!empty($state->name)):
                                                                                    echo html_escape($state->name) . "/";
                                                                                endif;
                                                                                if (!empty($country->name)):
                                                                                    echo html_escape($country->name);
                                                                                endif; ?>
                                                                            </p>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="address-right">
                                                                    <div class="dropdown dropdown-shipping-options">
                                                                        <button class="btn" type="button" data-toggle="dropdown">
                                                                            <svg width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                                            </svg>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#modalAddress<?= $address->id; ?>"><?= trans("edit"); ?></a>
                                                                            <a href="javascript:void(0)" class="dropdown-item" onclick='delete_shipping_address("<?= $address->id; ?>","<?= trans("confirm_delete"); ?>");'><?= trans("delete"); ?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $i++;
                                                    endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div id="cart_shipping_methods_container">
                                            <?php $this->load->view("cart/_shipping_methods"); ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="cart-shipping-loader">
                                                    <div class="spinner">
                                                        <div class="bounce1"></div>
                                                        <div class="bounce2"></div>
                                                        <div class="bounce3"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    <?php endif; ?>
                                </div>

                                <div class="tab-checkout tab-checkout-closed-bordered">
                                    <h2 class="title">2.&nbsp;&nbsp;<?php echo trans("payment_method"); ?></h2>
                                </div>

                                <div class="tab-checkout tab-checkout-closed-bordered border-top-0">
                                    <h2 class="title">3.&nbsp;&nbsp;<?php echo trans("payment"); ?></h2>
                                </div>
                            </div>
                        </div>

                        <?php if ($mds_payment_type == 'promote'):
                            $this->load->view("cart/_order_summary_promote");
                        else:
                            $this->load->view("cart/_order_summary");
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalAddAddress" class="modal fade modal-custom" role="dialog">
    <div class="modal-dialog modal-dialog-shipping-address">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="modal-title"><?= trans("add_new_address"); ?></h4>
            </div>
            <?php echo form_open("add-shipping-address-post", ['id' => 'form_add_shipping_address', 'class' => 'validate-form']); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label"><?= trans("address_title"); ?></label>
                    <input type="text" name="title" class="form-control form-input" placeholder="<?= trans("address_title"); ?>" maxlength="250" required>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6 m-b-sm-15">
                            <label class="control-label"><?= trans("first_name"); ?></label>
                            <input type="text" name="first_name" class="form-control form-input" placeholder="<?= trans("first_name"); ?>" maxlength="250" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="control-label"><?= trans("last_name"); ?></label>
                            <input type="text" name="last_name" class="form-control form-input" placeholder="<?= trans("last_name"); ?>" maxlength="250" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6 m-b-sm-15">
                            <label class="control-label"><?= trans("email"); ?></label>
                            <input type="email" name="email" class="form-control form-input" placeholder="<?= trans("email"); ?>" maxlength="250" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="control-label"><?= trans("phone_number"); ?></label>
                            <input type="text" name="phone_number" class="form-control form-input" placeholder="<?= trans("phone_number"); ?>" maxlength="100" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans("address"); ?></label>
                    <input type="text" name="address" class="form-control form-input" placeholder="<?= trans("address"); ?>" maxlength="490" required>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6 m-b-sm-15">
                            <label class="control-label"><?php echo trans("country"); ?></label>
                            <select id="select_countries_new_address" name="country_id" class="select2 select2-req form-control" data-placeholder="<?= trans("country"); ?>" onchange="get_states(this.value,false,'new_address');" required>
                                <option></option>
                                <?php foreach ($this->countries as $item): ?>
                                    <option value="<?= $item->id; ?>"><?= html_escape($item->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="get_states_container_new_address" class="col-12 col-md-6">
                            <label class="control-label"><?php echo trans("state"); ?></label>
                            <select id="select_states_new_address" name="state_id" class="select2 select2-req form-control" data-placeholder="<?= trans("state"); ?>" required>
                                <option></option>
                                <?php if (!empty($states)):
                                    foreach ($states as $item): ?>
                                        <option value="<?= $item->id; ?>"><?= html_escape($item->name); ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6 m-b-sm-15">
                            <label class="control-label"><?= trans("city"); ?></label>
                            <input type="text" name="city" class="form-control form-input" placeholder="<?= trans("city"); ?>" maxlength="250" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="control-label"><?= trans("zip_code"); ?></label>
                            <input type="text" name="zip_code" class="form-control form-input" placeholder="<?= trans("zip_code"); ?>" maxlength="90" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-custom m-0"><?= trans("submit"); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php if (!empty($shipping_addresses)):
    foreach ($shipping_addresses as $address):?>
        <div id="modalAddress<?= $address->id; ?>" class="modal fade modal-custom" role="dialog">
            <div class="modal-dialog modal-dialog-shipping-address">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                        <h4 class="modal-title"><?= trans("edit_address"); ?></h4>
                    </div>
                    <?php echo form_open("edit-shipping-address-post", ['id' => 'form_edit_shipping_address_' . $address->id, 'class' => 'validate-form']); ?>
                    <input type="hidden" name="id" value="<?= $address->id; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label"><?= trans("address_title"); ?></label>
                            <input type="text" name="title" class="form-control form-input" value="<?= html_escape($address->title); ?>" placeholder="<?= trans("address_title"); ?>" maxlength="250" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6 m-b-sm-15">
                                    <label class="control-label"><?= trans("first_name"); ?></label>
                                    <input type="text" name="first_name" class="form-control form-input" value="<?= html_escape($address->first_name); ?>" placeholder="<?= trans("first_name"); ?>" maxlength="250" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="control-label"><?= trans("last_name"); ?></label>
                                    <input type="text" name="last_name" class="form-control form-input" value="<?= html_escape($address->last_name); ?>" placeholder="<?= trans("last_name"); ?>" maxlength="250" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6 m-b-sm-15">
                                    <label class="control-label"><?= trans("email"); ?></label>
                                    <input type="email" name="email" class="form-control form-input" value="<?= html_escape($address->email); ?>" placeholder="<?= trans("email"); ?>" maxlength="250" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="control-label"><?= trans("phone_number"); ?></label>
                                    <input type="text" name="phone_number" class="form-control form-input" value="<?= html_escape($address->phone_number); ?>" placeholder="<?= trans("phone_number"); ?>" maxlength="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans("address"); ?></label>
                            <input type="text" name="address" class="form-control form-input" value="<?= html_escape($address->address); ?>" placeholder="<?= trans("address"); ?>" maxlength="490" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6 m-b-sm-15">
                                    <label class="control-label"><?php echo trans("country"); ?></label>
                                    <select id="select_countries_address_<?= $address->id; ?>" name="country_id" class="select2 form-control" onchange="get_states(this.value,false,'address_<?= $address->id; ?>');" required>
                                        <?php foreach ($this->countries as $item): ?>
                                            <option value="<?= $item->id; ?>" <?= $item->id == $address->country_id ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="get_states_container_address_<?= $address->id; ?>" class="col-12 col-md-6">
                                    <label class="control-label"><?php echo trans("state"); ?></label>
                                    <select id="select_states_address_<?= $address->id; ?>" name="state_id" class="select2 form-control" required>
                                        <?php $states = get_states_by_country($address->country_id);
                                        if (!empty($states)):
                                            foreach ($states as $item): ?>
                                                <option value="<?= $item->id; ?>" <?= $item->id == $address->state_id ? 'selected' : ''; ?>><?= html_escape($item->name); ?></option>
                                            <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-6 m-b-sm-15">
                                    <label class="control-label"><?= trans("city"); ?></label>
                                    <input type="text" name="city" class="form-control form-input" value="<?= html_escape($address->city); ?>" placeholder="<?= trans("city"); ?>" maxlength="250" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="control-label"><?= trans("zip_code"); ?></label>
                                    <input type="text" name="zip_code" class="form-control form-input" value="<?= html_escape($address->zip_code); ?>" placeholder="<?= trans("zip_code"); ?>" maxlength="90" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom m-0"><?= trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>


